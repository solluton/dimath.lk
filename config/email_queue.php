<?php
// Use simple database connection for queue operations to avoid session issues
if (php_sapi_name() === 'cli') {
    require_once __DIR__ . '/database_simple.php';
    // Use getSimpleDBConnection() directly instead of redeclaring getDBConnection()
} else {
    require_once __DIR__ . '/database.php';
}

/**
 * Add an email to the queue for background processing
 * 
 * @param string $to_email Recipient email address
 * @param string $from_email Sender email address
 * @param string $from_name Sender name
 * @param string $subject Email subject
 * @param string $body Email body content
 * @param bool $is_html Whether the email body is HTML
 * @param int $priority Priority level (1 = highest, 5 = lowest)
 * @param int $max_attempts Maximum number of send attempts
 * @return array Result array with success status and message
 */
function queueEmail($to_email, $from_email, $from_name, $subject, $body, $is_html = false, $priority = 1, $max_attempts = 3) {
    try {
        $pdo = (php_sapi_name() === 'cli') ? getSimpleDBConnection() : getDBConnection();
        
        $stmt = $pdo->prepare("
            INSERT INTO email_queue (
                to_email, from_email, from_name, subject, body, 
                is_html, priority, max_attempts, status, scheduled_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())
        ");
        
        $result = $stmt->execute([
            $to_email,
            $from_email, 
            $from_name,
            $subject,
            $body,
            $is_html ? 1 : 0,
            $priority,
            $max_attempts
        ]);
        
        if ($result) {
            $queue_id = $pdo->lastInsertId();
            return [
                'success' => true,
                'message' => 'Email queued successfully',
                'queue_id' => $queue_id
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to queue email'
            ];
        }
        
    } catch (PDOException $e) {
        error_log("Email queue error: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ];
    }
}

/**
 * Queue a contact form notification email
 * 
 * @param array $lead_data Contact form data
 * @return array Result array with success status and message
 */
function queueContactEmailNotification($lead_data) {
    // Load environment variables
    require_once __DIR__ . '/env.php';
    loadEnv();
    
    try {
        $pdo = (php_sapi_name() === 'cli') ? getSimpleDBConnection() : getDBConnection();
        
        // Get notification email from admin settings
        $notification_email = 'admin@neomed.lk'; // Default fallback
        
        try {
            $stmt = $pdo->prepare("SELECT setting_value FROM admin_settings WHERE setting_key = 'contact_email'");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result && !empty($result['setting_value'])) {
                $notification_email = $result['setting_value'];
            }
        } catch(PDOException $e) {
            error_log("Failed to get contact email from settings: " . $e->getMessage());
            // Keep the fallback email
        }
        
        // Generate email content
        $first_name = explode(' ', trim($lead_data['name']))[0];
        $last_name = trim(str_replace($first_name, '', $lead_data['name']));
        
        // Load company details for auto-reply
        require_once __DIR__ . '/email.php';
        $company_details = getCompanyDetails();
        $variables = getTemplateVariables($lead_data, $company_details);
        
        // 1. Queue admin notification email
        $admin_subject_template = $company_details['email_templates']['admin_notification']['subject'] ?? 'New Contact Form Submission - {{company_name}}';
        $admin_subject = processEmailTemplate($admin_subject_template, $variables);
        $admin_html_body = generateContactEmailTemplate($lead_data);
        
        $admin_queue_result = queueEmail(
            $notification_email,
            $_ENV['FROM_EMAIL'] ?? 'leads@solluton.com',
            $_ENV['FROM_NAME'] ?? 'Neomed | Website',
            $admin_subject,
            $admin_html_body,
            true, // is_html
            1,    // high priority
            3     // max attempts
        );
        
        // 2. Queue auto-reply email to customer
        $customer_subject_template = $company_details['email_templates']['auto_reply']['subject'] ?? '{{first_name}}, thank you for contacting {{company_name}} - We\'ve received your message';
        $customer_subject = processEmailTemplate($customer_subject_template, $variables);
        $customer_html_body = generateAutoReplyTemplate($lead_data, $company_details);
        
        $customer_queue_result = queueEmail(
            $lead_data['email'], // Send to the person who submitted the form
            $_ENV['FROM_EMAIL'] ?? 'leads@solluton.com',
            $_ENV['FROM_NAME'] ?? 'Neomed | Website',
            $customer_subject,
            $customer_html_body,
            true, // is_html
            2,    // normal priority (lower than admin notification)
            3     // max attempts
        );
        
        // Return success if at least one email was queued successfully
        if ($admin_queue_result['success'] || $customer_queue_result['success']) {
            $message = 'Emails queued: ';
            $queued_emails = [];
            
            if ($admin_queue_result['success']) {
                $queued_emails[] = 'admin notification';
            }
            if ($customer_queue_result['success']) {
                $queued_emails[] = 'customer auto-reply';
            }
            
            return [
                'success' => true,
                'message' => $message . implode(', ', $queued_emails),
                'admin_queue_id' => $admin_queue_result['queue_id'] ?? null,
                'customer_queue_id' => $customer_queue_result['queue_id'] ?? null,
                'details' => [
                    'admin_notification' => $admin_queue_result,
                    'customer_auto_reply' => $customer_queue_result
                ]
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to queue both emails: Admin - ' . $admin_queue_result['message'] . ', Customer - ' . $customer_queue_result['message']
            ];
        }
        
    } catch (Exception $e) {
        error_log("Contact email queue error: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Error queuing contact notification: ' . $e->getMessage()
        ];
    }
}

/**
 * Get pending emails from the queue
 * 
 * @param int $limit Maximum number of emails to retrieve
 * @return array Array of pending email records
 */
function getPendingEmails($limit = 10) {
    try {
        $pdo = (php_sapi_name() === 'cli') ? getSimpleDBConnection() : getDBConnection();
        
        $stmt = $pdo->prepare("
            SELECT * FROM email_queue 
            WHERE status = 'pending' 
            AND attempts < max_attempts 
            AND scheduled_at <= NOW()
            ORDER BY priority ASC, scheduled_at ASC 
            LIMIT ?
        ");
        
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        error_log("Error fetching pending emails: " . $e->getMessage());
        return [];
    }
}

/**
 * Update email queue status
 * 
 * @param int $queue_id Email queue ID
 * @param string $status New status (processing, sent, failed)
 * @param string $error_message Optional error message for failed emails
 * @return bool Success status
 */
function updateEmailQueueStatus($queue_id, $status, $error_message = null) {
    try {
        $pdo = (php_sapi_name() === 'cli') ? getSimpleDBConnection() : getDBConnection();
        
        $sql = "UPDATE email_queue SET status = ?, updated_at = NOW()";
        $params = [$status];
        
        if ($status === 'sent') {
            $sql .= ", processed_at = NOW()";
        }
        
        if ($error_message) {
            $sql .= ", error_message = ?";
            $params[] = $error_message;
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $queue_id;
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
        
    } catch (PDOException $e) {
        error_log("Error updating email queue status: " . $e->getMessage());
        return false;
    }
}

/**
 * Increment email attempt count
 * 
 * @param int $queue_id Email queue ID
 * @return bool Success status
 */
function incrementEmailAttempts($queue_id) {
    try {
        $pdo = (php_sapi_name() === 'cli') ? getSimpleDBConnection() : getDBConnection();
        
        $stmt = $pdo->prepare("
            UPDATE email_queue 
            SET attempts = attempts + 1, updated_at = NOW() 
            WHERE id = ?
        ");
        
        return $stmt->execute([$queue_id]);
        
    } catch (PDOException $e) {
        error_log("Error incrementing email attempts: " . $e->getMessage());
        return false;
    }
}

/**
 * Clean up old processed emails from the queue
 * 
 * @param int $days_old Number of days to keep processed emails
 * @return int Number of deleted records
 */
function cleanupEmailQueue($days_old = 7) {
    try {
        $pdo = (php_sapi_name() === 'cli') ? getSimpleDBConnection() : getDBConnection();
        
        $stmt = $pdo->prepare("
            DELETE FROM email_queue 
            WHERE status IN ('sent', 'failed') 
            AND updated_at < DATE_SUB(NOW(), INTERVAL ? DAY)
        ");
        
        $stmt->execute([$days_old]);
        return $stmt->rowCount();
        
    } catch (PDOException $e) {
        error_log("Error cleaning up email queue: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get email queue statistics
 * 
 * @return array Queue statistics
 */
function getEmailQueueStats() {
    try {
        $pdo = (php_sapi_name() === 'cli') ? getSimpleDBConnection() : getDBConnection();
        
        $stmt = $pdo->query("
            SELECT 
                status,
                COUNT(*) as count
            FROM email_queue 
            GROUP BY status
        ");
        
        $stats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stats[$row['status']] = (int)$row['count'];
        }
        
        return $stats;
        
    } catch (PDOException $e) {
        error_log("Error getting email queue stats: " . $e->getMessage());
        return [];
    }
}

// Include the email template function from the main email config
require_once __DIR__ . '/email.php';
?>
