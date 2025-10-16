<?php
require_once 'config/env.php';
require_once 'config/database.php';
require_once 'config/csrf.php';
require_once 'config/email_queue.php';

// Check if this is an AJAX request (keep JSON) or form submission (redirect)
$accepts_json = isset($_SERVER['HTTP_ACCEPT']) && stripos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;
$is_ajax_header = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$is_ajax_param = isset($_POST['ajax']) && $_POST['ajax'] == '1';
$is_ajax = $is_ajax_header || $is_ajax_param || $accepts_json;

if ($is_ajax) {
    // AJAX request - prepare JSON response and suppress notices in output
    header('Content-Type: application/json');
    @ini_set('display_errors', 0);
    if (function_exists('ob_start')) { @ob_start(); }
    $response = [
        'success' => false,
        'message' => '',
        'errors' => [],
        'data' => []
    ];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate CSRF token for AJAX requests (header or POST field)
    if ($is_ajax) {
        $csrf_header = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        $csrf_ok = false;
        if (!empty($csrf_header)) {
            $csrf_ok = validateCSRFToken($csrf_header);
        }
        if (!$csrf_ok) {
            // fallback to POST field
            $csrf_ok = validateCSRFPost();
        }
        if (!$csrf_ok) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'CSRF validation failed (ajax)']);
            exit();
        }
    }
    
    // Handle both old cinnamon site and new sports site field names
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $name = trim($_POST['name'] ?? $_POST['Name'] ?? (($first_name . ' ' . $last_name)));
    $email = trim($_POST['email'] ?? $_POST['Email'] ?? '');
    $phone = trim($_POST['phone'] ?? $_POST['Phone'] ?? '');
    $company = trim($_POST['company'] ?? 'Dimath Sports Contact');
    $subject = trim($_POST['subject'] ?? $_POST['Reason'] ?? '');
    $message_text = trim($_POST['message'] ?? $_POST['Message'] ?? '');
    $terms = $_POST['terms'] ?? '';
    
    // Comprehensive validation
    $validation_errors = [];
    
    // Name validation (split to first/last for field-level errors)
    if (empty($first_name) && empty($name)) {
        $validation_errors['first_name'] = 'First name is required.';
    } elseif (!empty($first_name) && strlen($first_name) < 2) {
        $validation_errors['first_name'] = 'First name must be at least 2 characters.';
    }
    if (empty($last_name) && empty($name)) {
        $validation_errors['last_name'] = 'Last name is required.';
    } elseif (!empty($last_name) && strlen($last_name) < 2) {
        $validation_errors['last_name'] = 'Last name must be at least 2 characters.';
    }
    
    // Email validation
    if (empty($email)) {
        $validation_errors['email'] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validation_errors['email'] = 'Please enter a valid email address.';
    } elseif (strlen($email) > 255) {
        $validation_errors['email'] = 'Email address is too long.';
    } elseif (preg_match('/[<>"\']/', $email)) {
        $validation_errors['email'] = 'Email address contains invalid characters.';
    }
    
    // Phone validation (optional)
    if (!empty($phone)) {
        // Remove all non-digit characters for validation
        $digits_only = preg_replace('/\D/', '', $phone);
        
        // Check if it has at least 7 digits and not more than 15
        if (strlen($digits_only) < 7 || strlen($digits_only) > 15) {
            $validation_errors['phone'] = 'Phone number must be between 7 and 15 digits.';
        }
        
        // Check if it contains valid characters (digits, +, -, spaces, parentheses)
        if (!preg_match('/^[\d\+\-\s\(\)]+$/', $phone)) {
            $validation_errors['phone'] = 'Phone number contains invalid characters.';
        }
        
        // Check for suspicious patterns
        if (preg_match('/(.)\1{4,}/', $phone)) {
            $validation_errors['phone'] = 'Phone number appears to be invalid.';
        }
    }
    
    // Company validation (optional but validate if provided)
    if (!empty($company) && strlen($company) > 255) {
        $validation_errors['company'] = 'Company name is too long.';
    }
    
    // Subject validation (required by UI)
    if (empty($subject)) {
        $validation_errors['subject'] = 'Please choose a topic.';
    } elseif (strlen($subject) > 255) {
        $validation_errors['subject'] = 'Subject is too long.';
    }
    // Terms acceptance (required)
    if (empty($terms)) {
        $validation_errors['terms'] = 'You must accept the Terms.';
    }
    
    // Message validation
    if (empty($message_text)) {
        $validation_errors['message'] = 'Message is required.';
    } elseif (strlen($message_text) < 10) {
        $validation_errors['message'] = 'Message must be at least 10 characters long.';
    } elseif (strlen($message_text) > 5000) {
        $validation_errors['message'] = 'Message must not exceed 5000 characters.';
    }
    
    // Check for spam patterns
    $spam_keywords = ['viagra', 'casino', 'lottery', 'winner', 'congratulations', 'click here', 'free money', 'bitcoin', 'cryptocurrency', 'investment', 'loan', 'debt', 'refinance'];
    $message_lower = strtolower($message_text);
    foreach ($spam_keywords as $keyword) {
        if (strpos($message_lower, $keyword) !== false) {
            $validation_errors['message'] = 'Your message contains content that appears to be spam.';
            break;
        }
    }
    
    // Check for excessive repetition
    if (preg_match('/(.)\1{10,}/', $message_text)) {
        $validation_errors['message'] = 'Message contains excessive repetition.';
    }
    
    // Allow URLs in message; no restriction here
    
    // Rate limiting - check for too many submissions from same IP
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
    if (!empty($ip_address)) {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM contact_leads WHERE ip_address = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
            $stmt->execute([$ip_address]);
            $recent_submissions = $stmt->fetchColumn();
            
            if ($recent_submissions >= 5) {
                $validation_errors['general'] = 'Too many submissions from your IP address. Please try again later.';
            }
        } catch(PDOException $e) {
            // Continue with submission if rate limiting check fails
            error_log("Rate limiting check failed: " . $e->getMessage());
        }
    }
    
    // Check for duplicate submissions (same email and message within 24 hours)
    if (!empty($email) && !empty($message_text)) {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM contact_leads WHERE email = ? AND message = ? AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)");
            $stmt->execute([$email, $message_text]);
            $duplicate_submissions = $stmt->fetchColumn();
            
            if ($duplicate_submissions > 0) {
                $validation_errors['general'] = 'You have already submitted this message recently.';
            }
        } catch(PDOException $e) {
            // Continue with submission if duplicate check fails
            error_log("Duplicate check failed: " . $e->getMessage());
        }
    }
    
    // Set validation errors to response
    if (!empty($validation_errors)) {
        if ($is_ajax) {
            http_response_code(422);
        }
        if (!isset($response)) { $response = ['success' => false, 'message' => '', 'errors' => [], 'data' => []]; }
        $response['errors'] = $validation_errors;
        // Provide a concise message for the client UI
        $response['message'] = 'Please correct the highlighted fields and try again.';
    }
    
    if (empty($response['errors'])) {
        try {
            $pdo = getDBConnection();
            
            // Clean phone number (keep original format for storage)
            $clean_phone = !empty($phone) ? trim($phone) : '';
            
            // Get client IP and user agent
            $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
            
            // Build combined name and sanitize inputs
            $nameCombined = trim($name ?: (trim($first_name . ' ' . $last_name)));
            if (strlen($nameCombined) > 100) { $nameCombined = substr($nameCombined, 0, 100); }
            $nameCombined = htmlspecialchars($nameCombined, ENT_QUOTES, 'UTF-8');
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $company = htmlspecialchars($company, ENT_QUOTES, 'UTF-8');
            $subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
            $message_text = htmlspecialchars($message_text, ENT_QUOTES, 'UTF-8');
            
            $stmt = $pdo->prepare("INSERT INTO contact_leads (name, first_name, last_name, email, phone, company, subject, message, terms_accepted, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            $execute_result = $stmt->execute([
                $nameCombined,
                $first_name ?: null,
                $last_name ?: null,
                $email,
                $clean_phone,
                $company,
                $subject,
                $message_text,
                !empty($terms) ? 1 : 0,
                $ip_address,
                $user_agent
            ]);
            
            if ($execute_result) {
                $lead_id = $pdo->lastInsertId();
                
                // Queue email notification for background processing
                $lead_data = [
                    'name' => $nameCombined,
                    'email' => $email,
                    'phone' => $clean_phone,
                    'company' => $company,
                    'subject' => $subject,
                    'message' => $message_text,
                    'ip_address' => $ip_address
                ];
                
                $queue_result = queueContactEmailNotification($lead_data);
                if (!$queue_result['success']) {
                    error_log("Contact email queue failed: " . $queue_result['message']);
                }
                
                if ($is_ajax) {
                    $response['success'] = true;
                    $response['message'] = 'Thank you for your ' . $subject . ' inquiry! Our team will review your message and get back to you within 24 hours.';
                    $response['data'] = [
                        'lead_id' => $lead_id,
                        'email_queued' => $queue_result['success'] ?? false,
                        'queue_id' => $queue_result['queue_id'] ?? null
                    ];
                } else {
                    // Set success flag for redirect
                    $success = true;
                    // Refresh CSRF token to prevent resubmission
                    if (function_exists('regenerateCSRFToken')) { regenerateCSRFToken(); }
                }
            } else {
                $errorInfo = $stmt->errorInfo();
                $response['message'] = 'Database insert failed: ' . $errorInfo[2];
                $response['debug'] = [
                    'sql_state' => $errorInfo[0],
                    'error_code' => $errorInfo[1],
                    'error_message' => $errorInfo[2]
                ];
            }
        } catch(PDOException $e) {
            error_log("Database error in contact handler: " . $e->getMessage());
            $response['message'] = 'Database error: ' . $e->getMessage();
            $response['debug'] = [
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ];
        } catch(Exception $e) {
            error_log("General error in contact handler: " . $e->getMessage());
            $response['message'] = 'General error: ' . $e->getMessage();
            $response['debug'] = [
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ];
        }
    }
} else {
    if ($is_ajax) {
        $response['message'] = 'This endpoint only accepts POST requests. Please use the contact form to submit your message.';
        $response['errors']['general'] = 'Direct access to this endpoint is not allowed.';
    } else {
        // Redirect to contact page with error
        header('Location: ./contact?error=1');
        exit();
    }
}

if ($is_ajax) {
    // Return JSON response for AJAX
    if (function_exists('ob_get_clean')) {
        $preOutput = @ob_get_clean();
        if (!empty($preOutput)) { error_log('AJAX contact pre-output: ' . substr($preOutput, 0, 1000)); }
    }
    echo json_encode($response);
    exit();
} else {
    // Redirect for regular form submission
    if (isset($success)) {
        // Redirect to success page
        header('Location: ./contact?success=1');
        exit();
    } else {
        // Redirect to contact page with error
        $reason = 'unknown';
        if (!empty($response['errors'])) { $reason = 'validation'; }
        elseif (!empty($response['message'])) { $reason = 'server'; }
        header('Location: ./contact?error=1&reason=' . urlencode($reason));
        exit();
    }
}

// Old function removed - now using PHPMailer from config/email.php
?>
