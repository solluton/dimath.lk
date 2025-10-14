<?php
/**
 * Email Queue Processor
 * 
 * This script processes pending emails from the queue and sends them using PHPMailer.
 * It should be run via cron job every few minutes.
 * 
 * Usage: php process_email_queue.php [--limit=10] [--verbose]
 */

require_once __DIR__ . '/config/email_queue.php';
require_once __DIR__ . '/config/email.php';

// Parse command line arguments
$options = getopt('', ['limit:', 'verbose', 'help']);

if (isset($options['help'])) {
    echo "Email Queue Processor\n";
    echo "Usage: php process_email_queue.php [--limit=10] [--verbose]\n";
    echo "  --limit=N    Process maximum N emails (default: 10)\n";
    echo "  --verbose    Show detailed output\n";
    echo "  --help       Show this help message\n";
    exit(0);
}

$limit = isset($options['limit']) ? (int)$options['limit'] : 10;
$verbose = isset($options['verbose']);

// Prevent multiple instances from running simultaneously
$lock_file = __DIR__ . '/email_queue.lock';
$lock_handle = fopen($lock_file, 'w');

if (!flock($lock_handle, LOCK_EX | LOCK_NB)) {
    if ($verbose) {
        echo "[" . date('Y-m-d H:i:s') . "] Another instance is already running. Exiting.\n";
    }
    exit(0);
}

// Log start time
$start_time = microtime(true);
$processed_count = 0;
$success_count = 0;
$failed_count = 0;

if ($verbose) {
    echo "[" . date('Y-m-d H:i:s') . "] Starting email queue processing (limit: $limit)\n";
}

try {
    // Get pending emails from queue
    $pending_emails = getPendingEmails($limit);
    
    if (empty($pending_emails)) {
        if ($verbose) {
            echo "[" . date('Y-m-d H:i:s') . "] No pending emails found.\n";
        }
        exit(0);
    }
    
    if ($verbose) {
        echo "[" . date('Y-m-d H:i:s') . "] Found " . count($pending_emails) . " pending emails.\n";
    }
    
    foreach ($pending_emails as $email) {
        $processed_count++;
        $queue_id = $email['id'];
        
        if ($verbose) {
            echo "[" . date('Y-m-d H:i:s') . "] Processing email ID: $queue_id to {$email['to_email']}\n";
        }
        
        // Mark as processing
        updateEmailQueueStatus($queue_id, 'processing');
        
        try {
            // Increment attempt count
            incrementEmailAttempts($queue_id);
            
            // Send the email using PHPMailer
            $send_result = sendEmail(
                $email['to_email'],
                $email['subject'],
                $email['body'],
                $email['is_html'],
                $email['from_email'],
                $email['from_name']
            );
            
            if ($send_result['success']) {
                // Mark as sent
                updateEmailQueueStatus($queue_id, 'sent');
                $success_count++;
                
                if ($verbose) {
                    echo "[" . date('Y-m-d H:i:s') . "] ✅ Email ID: $queue_id sent successfully\n";
                }
            } else {
                // Check if we've reached max attempts
                if ($email['attempts'] + 1 >= $email['max_attempts']) {
                    updateEmailQueueStatus($queue_id, 'failed', $send_result['message']);
                    if ($verbose) {
                        echo "[" . date('Y-m-d H:i:s') . "] ❌ Email ID: $queue_id failed permanently: {$send_result['message']}\n";
                    }
                } else {
                    updateEmailQueueStatus($queue_id, 'pending', $send_result['message']);
                    if ($verbose) {
                        echo "[" . date('Y-m-d H:i:s') . "] ⚠️ Email ID: $queue_id failed, will retry: {$send_result['message']}\n";
                    }
                }
                $failed_count++;
            }
            
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            
            // Check if we've reached max attempts
            if ($email['attempts'] + 1 >= $email['max_attempts']) {
                updateEmailQueueStatus($queue_id, 'failed', $error_message);
                if ($verbose) {
                    echo "[" . date('Y-m-d H:i:s') . "] ❌ Email ID: $queue_id failed permanently: $error_message\n";
                }
            } else {
                updateEmailQueueStatus($queue_id, 'pending', $error_message);
                if ($verbose) {
                    echo "[" . date('Y-m-d H:i:s') . "] ⚠️ Email ID: $queue_id failed, will retry: $error_message\n";
                }
            }
            $failed_count++;
            
            error_log("Email queue processing error for ID $queue_id: " . $e->getMessage());
        }
        
        // Small delay to prevent overwhelming the SMTP server
        usleep(100000); // 0.1 seconds
    }
    
} catch (Exception $e) {
    error_log("Email queue processor error: " . $e->getMessage());
    if ($verbose) {
        echo "[" . date('Y-m-d H:i:s') . "] ❌ Fatal error: " . $e->getMessage() . "\n";
    }
} finally {
    // Release the lock
    flock($lock_handle, LOCK_UN);
    fclose($lock_handle);
    unlink($lock_file);
}

// Log completion
$end_time = microtime(true);
$execution_time = round($end_time - $start_time, 2);

if ($verbose || $processed_count > 0) {
    echo "[" . date('Y-m-d H:i:s') . "] Processing complete: $processed_count processed, $success_count sent, $failed_count failed ({$execution_time}s)\n";
}

// Log statistics to error log for monitoring
if ($processed_count > 0) {
    error_log("Email queue processed: $processed_count emails, $success_count sent, $failed_count failed in {$execution_time}s");
}

// Clean up old processed emails (run occasionally)
if (rand(1, 100) <= 5) { // 5% chance
    $cleaned = cleanupEmailQueue(7); // Keep for 7 days
    if ($verbose && $cleaned > 0) {
        echo "[" . date('Y-m-d H:i:s') . "] Cleaned up $cleaned old email records\n";
    }
}

exit(0);
?>
