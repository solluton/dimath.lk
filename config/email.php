<?php
// Email configuration using PHPMailer
require_once __DIR__ . '/env.php';
require_once __DIR__ . '/url_helper.php';
require_once __DIR__ . '/../phpmailer/src/Exception.php';
require_once __DIR__ . '/../phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Send email using PHPMailer with SMTP authentication
 */
function sendEmail($to, $subject, $message, $is_html = false, $from_email = null, $from_name = null) {
    // Get email settings from environment
    $smtp_host = env('SMTP_HOST', 'premium5.web-hosting.com');
    $smtp_port = env('SMTP_PORT', '587');
    $smtp_username = env('SMTP_USERNAME', 'leads@solluton.com');
    $smtp_password = env('SMTP_PASSWORD', '');
    $smtp_encryption = env('SMTP_ENCRYPTION', 'tls');
    
    // Default from email and name
    $from_email = $from_email ?: env('FROM_EMAIL', 'info@dimath.lk');
    $from_name = $from_name ?: env('FROM_NAME', 'Dimath Group');
    
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = $smtp_encryption;
        $mail->Port = $smtp_port;
        
        // Enable verbose debug output (for testing)
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        
        // Recipients
        $mail->setFrom($from_email, $from_name);
        $mail->addAddress($to);
        $mail->addReplyTo($from_email, $from_name);
        
        // Content
        $mail->isHTML($is_html); // Set to true if sending HTML emails
        $mail->Subject = $subject;
        $mail->Body = $message;
        
        // Send the email
        $result = $mail->send();
        
        // Get message ID for debugging
        $message_id = $mail->getLastMessageID();
        
        return [
            'success' => true,
            'message' => 'Email sent successfully',
            'debug_info' => [
                'smtp_host' => $smtp_host,
                'smtp_port' => $smtp_port,
                'smtp_username' => $smtp_username,
                'smtp_encryption' => $smtp_encryption,
                'from_email' => $from_email,
                'from_name' => $from_name,
                'to' => $to,
                'subject' => $subject,
                'message_id' => $message_id
            ]
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Email could not be sent. Error: {$mail->ErrorInfo}",
            'error' => $e->getMessage(),
            'debug_info' => [
                'smtp_host' => $smtp_host,
                'smtp_port' => $smtp_port,
                'smtp_username' => $smtp_username,
                'smtp_encryption' => $smtp_encryption,
                'from_email' => $from_email,
                'from_name' => $from_name,
                'to' => $to,
                'subject' => $subject,
                'message_id' => null
            ]
        ];
    }
}

/**
 * Send contact form notification email
 */
function sendContactEmailNotification($lead_data) {
    // Get notification email from database
    require_once __DIR__ . '/database.php';
    $pdo = getDBConnection();
    
    // Get contact email from admin_settings
    try {
        $stmt = $pdo->prepare("SELECT setting_value FROM admin_settings WHERE setting_key = 'contact_email'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && !empty($result['setting_value'])) {
            $notification_email = $result['setting_value'];
        } else {
            $notification_email = 'info@dimath.lk'; // Fallback
        }
    } catch(PDOException $e) {
        $notification_email = 'info@dimath.lk'; // Fallback on error
        error_log("Failed to get contact email from settings: " . $e->getMessage());
    }
    
    $to = $notification_email;
    $subject = env('LEAD_EMAIL_SUBJECT', 'New Contact Form Submission - Dimath Sports');
    
    // Generate HTML email template
    $html_message = generateContactEmailTemplate($lead_data);
    
    return sendEmail($to, $subject, $html_message, true);
}

/**
 * Generate HTML email template for contact form notifications
 */
function generateContactEmailTemplate($lead_data) {
    $company_details = getCompanyDetails();
    $variables = getTemplateVariables($lead_data, $company_details);
    $templates = $company_details['email_templates']['admin_notification'];
    
    // Split name into first and last name for backward compatibility
    $first_name = $variables['first_name'];
    $last_name = $variables['last_name'];
    
    $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Lead Notification</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset styles for email compatibility */
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
        
        /* Main container styles */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            font-family: \'Inter\', Arial, sans-serif;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .top-logo {
            text-align: center;
            padding: 40px 20px 0px 20px;
            background-color: #ffffff;
        }
        
        .logo-image {
            max-width: 120px;
            height: auto;
        }
        
        .header {
            background-color: #ffffff;
            padding: 30px 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .logo-bar {
            width: 4px;
            height: 30px;
            background-color: #007bff;
            margin-right: 10px;
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #000000;
            text-decoration: none;
        }
        
        .main-message {
            font-size: 18px;
            color: #000000;
            margin: 20px 0;
            line-height: 1.4;
            text-align: center;
        }
        
        .form-data-section {
            background-color: #f8f9fa;
            margin: 30px 20px;
            padding: 30px;
            border-radius: 4px;
            border-left: 4px solid #007bff;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #000000;
            margin-bottom: 25px;
        }
        
        /* Table-based layout for form fields */
        .form-field-table {
            width: 100%;
        }

        .form-field-row td {
            padding: 15px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .form-field-row:last-child td {
            border-bottom: none;
        }

        .field-label {
            font-weight: 600;
            color: #000000;
            vertical-align: top;
            padding-right: 20px;
            width: 30%; /* Adjust as needed */
        }

        .field-value {
            color: #000000;
            text-align: right;
            vertical-align: top;
            width: 70%; /* Adjust as needed */
        }
        
        .email-link {
            color: #007bff;
            text-decoration: underline;
        }
        
        .cta-section {
            text-align: center;
            margin: 30px 20px;
        }
        
        .cta-button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            font-size: 16px;
        }
        
        .cta-button:hover {
            background-color: #0056b3;
        }
        
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }
        
        .footer-logo {
            max-width: 120px;
            height: auto;
            margin-bottom: 10px;
        }
        
        .powered-by {
            font-size: 12px;
            color: #007bff;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .company-details {
            font-size: 11px;
            color: #888888;
            line-height: 1.4;
        }
        
        .company-details a {
            color: #888888;
            text-decoration: none;
        }
        
        .company-details a:hover {
            color: #666666;
        }
        
        .contact-item {
            display: inline-flex;
            align-items: center;
            margin: 0 5px;
        }
        
        .contact-icon {
            width: 12px;
            height: 12px;
            margin-right: 5px;
        }
        
        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }
            
            .form-data-section {
                margin: 10px;
                padding: 15px;
            }
            
            .form-field-row td {
                display: block;
                text-align: left;
                padding: 5px 0;
            }

            .field-label {
                width: 100%;
                text-align: left;
                padding-right: 0;
                padding-bottom: 8px;
            }

            .field-value {
                width: 100%;
                text-align: left;
            }
            
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Top Logo Section -->
        <div class="top-logo">
            <img src="' . (!empty($company_details['logo_url']) ? htmlspecialchars($company_details['logo_url']) : asset('images/Dimath-Logo.png')) . '" alt="' . htmlspecialchars($company_details['company_name']) . '" class="logo-image">
        </div>
        
        <!-- Header Section -->
        <div class="header">
            <div class="main-message">
                ' . processEmailTemplate($templates['congratulations_message'], $variables) . '
            </div>
        </div>
        
        <!-- Form Data Section -->
        <div class="form-data-section">
            <div class="section-title">' . processEmailTemplate($templates['lead_info_title'], $variables) . '</div>
            
            <table role="presentation" class="form-field-table" border="0" cellspacing="0" cellpadding="0">
                <tr class="form-field-row">
                    <td class="field-label">First Name:</td>
                    <td class="field-value">' . htmlspecialchars($first_name) . '</td>
                </tr>
                <tr class="form-field-row">
                    <td class="field-label">Last Name:</td>
                    <td class="field-value">' . htmlspecialchars($last_name) . '</td>
                </tr>
                <tr class="form-field-row">
                    <td class="field-label">Email:</td>
                    <td class="field-value">
                        <a href="mailto:' . htmlspecialchars($lead_data['email']) . '" class="email-link">' . htmlspecialchars($lead_data['email']) . '</a>
                    </td>
                </tr>
                <tr class="form-field-row">
                    <td class="field-label">Phone Number:</td>
                    <td class="field-value">' . htmlspecialchars($lead_data['phone'] ?? 'Not provided') . '</td>
                </tr>';

    // Add company field if provided
    if (!empty($lead_data['company'])) {
        $html .= '<tr class="form-field-row">
                    <td class="field-label">Company:</td>
                    <td class="field-value">' . htmlspecialchars($lead_data['company']) . '</td>
                </tr>';
    }

    // Add subject field if provided
    if (!empty($lead_data['subject'])) {
        $html .= '<tr class="form-field-row">
                    <td class="field-label">Subject:</td>
                    <td class="field-value">' . htmlspecialchars($lead_data['subject']) . '</td>
                </tr>';
    }

    $html .= '<tr class="form-field-row">
                    <td class="field-label">Message:</td>
                    <td class="field-value">
                        <p>' . nl2br(htmlspecialchars($lead_data['message'])) . '</p>
                    </td>
                </tr>
            </table>
        </div>
        
        ' . ($templates['show_cta_button'] ? '
        <div class="cta-section">
            <a href="' . processEmailTemplate($templates['cta_button_url'], $variables) . '" class="cta-button">' . processEmailTemplate($templates['cta_button_text'], $variables) . '</a>
        </div>
        ' : '') . '
        
        <!-- Footer Section -->
        <div class="footer">
            <div class="powered-by">Powered by</div>
            <a href="' . htmlspecialchars($company_details['website']) . '" target="_blank">
                <img src="' . (!empty($company_details['logo_url']) ? htmlspecialchars($company_details['logo_url']) : asset('images/Dimath-Logo.png')) . '" alt="' . htmlspecialchars($company_details['company_name']) . '" class="footer-logo">
            </a>
            <div class="company-details">
                <span class="contact-item">
                    <svg class="contact-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                    </svg>
                    <a href="tel:' . htmlspecialchars($company_details['phone']) . '">' . htmlspecialchars($company_details['phone']) . '</a>
                </span>
                <span class="contact-item">
                    <svg class="contact-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                    <a href="mailto:' . htmlspecialchars($company_details['email']) . '">' . htmlspecialchars($company_details['email']) . '</a>
                </span>
            </div>
        </div>
    </div>
</body>
</html>';

    return $html;
}

/**
 * Load company details from JSON file
 */
function getCompanyDetails() {
    $json_file = __DIR__ . '/company_details.json';
    if (file_exists($json_file)) {
        $json_content = file_get_contents($json_file);
        return json_decode($json_content, true);
    }
    
    // Fallback company details
    return [
        'company_name' => 'Dimath Sports',
        'website' => 'https://dimath.lk',
        'email' => 'info@dimath.lk',
        'phone' => '+94 77 123 4567',
        'email_templates' => [
            'auto_reply' => [
                'subject' => '{{first_name}}, thank you for contacting {{company_name}} - We\'ve received your message',
                'greeting' => 'Thank you for reaching out to us!',
                'main_message' => 'We have successfully received your inquiry and our team will review your message carefully.',
                'closing_message' => 'We appreciate your interest in {{company_name}} and look forward to assisting you.'
            ]
        ]
    ];
}

/**
 * Process email template with variables
 */
function processEmailTemplate($template, $variables) {
    $processed = $template;
    
    // Replace all variables in the format {{variable_name}}
    foreach ($variables as $key => $value) {
        $processed = str_replace('{{' . $key . '}}', $value, $processed);
    }
    
    return $processed;
}

/**
 * Get time-based greeting
 */
function getTimeBasedGreeting() {
    $current_hour = (int)date('H');
    
    if ($current_hour >= 0 && $current_hour < 12) {
        return 'Good morning';
    } elseif ($current_hour >= 12 && $current_hour < 18) {
        return 'Good afternoon';
    } else {
        return 'Good evening';
    }
}

/**
 * Get priority and response time based on subject
 */
function getPriorityInfo($subject) {
    $priority_mapping = [
        'Technical Support' => 'high',
        'Billing Question' => 'high',
        'Customer Support' => 'medium',
        'Partnership' => 'medium',
        'General Inquiry' => 'low',
        'Product Information' => 'low',
        'Other' => 'low'
    ];
    
    $response_time_mapping = [
        'high' => '4 hours',
        'medium' => '24 hours',
        'low' => '48 hours'
    ];
    
    $priority = $priority_mapping[$subject] ?? 'low';
    $response_time = $response_time_mapping[$priority];
    
    return ['priority' => $priority, 'response_time' => $response_time];
}

/**
 * Get business day aware response time
 */
function getBusinessDayResponse($response_time) {
    $current_day = date('N'); // 1 (Monday) to 7 (Sunday)
    $is_weekend = ($current_day == 6 || $current_day == 7); // Saturday or Sunday
    
    if ($is_weekend) {
        return 'by the next business day';
    } else {
        return 'within ' . $response_time;
    }
}

/**
 * Get template variables for email processing
 */
function getTemplateVariables($lead_data, $company_details) {
    // Parse name
    $first_name = explode(' ', trim($lead_data['name']))[0];
    $last_name = trim(str_replace($first_name, '', $lead_data['name']));
    
    // Get priority and response time based on subject
    $subject = $lead_data['subject'] ?? 'General Inquiry';
    $priority_info = getPriorityInfo($subject);
    
    // Get conditional variables
    $greeting_time = getTimeBasedGreeting();
    $response_urgency = getBusinessDayResponse($priority_info['response_time']);
    
    return [
        // Personal information
        'first_name' => $first_name,
        'last_name' => $last_name,
        'full_name' => $lead_data['name'],
        'email' => $lead_data['email'],
        'phone' => $lead_data['phone'] ?? '',
        'subject' => $subject,
        'message' => $lead_data['message'],
        'company' => $lead_data['company'] ?? '',
        
        // Company information
        'company_name' => $company_details['company_name'],
        'company_email' => $company_details['email'],
        'company_phone' => $company_details['phone'],
        'company_website' => $company_details['website'],
        
        // Submission information
        'submission_source' => 'website',
        'priority_level' => $priority_info['priority'],
        'response_time' => $priority_info['response_time'],
        'response_urgency' => $response_urgency,
        
        // Date and time
        'current_year' => date('Y'),
        'current_date' => date('F j, Y'),
        'current_time' => date('g:i A'),
        'current_datetime' => date('F j, Y \a\t g:i A'),
        'submission_date' => date('F j, Y \a\t g:i A'),
        
        // Conditional variables
        'greeting_time' => $greeting_time,
        
        // Template defaults
        'greeting' => $company_details['email_templates']['auto_reply']['greeting'] ?? 'Thank you for reaching out to us!'
    ];
}

/**
 * Generate auto-reply email template for contact form submissions
 */
function generateAutoReplyTemplate($lead_data, $company_details) {
    $variables = getTemplateVariables($lead_data, $company_details);
    $templates = $company_details['email_templates']['auto_reply'];
    $first_name = $variables['first_name'];
    
    $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - ' . htmlspecialchars($company_details['company_name']) . '</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset styles for email compatibility */
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        /* Main container styles */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            font-family: \'Inter\', Arial, sans-serif;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            padding: 40px 20px;
            text-align: center;
            color: #333;
        }

        .logo-image {
            max-width: 120px;
            height: auto;
            margin-bottom: 20px;
        }

        .header-title {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px 0;
            line-height: 1.2;
        }

        .header-subtitle {
            font-size: 16px;
            margin: 0;
            opacity: 0.9;
        }

        .content-section {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .message-text {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 25px;
        }

        .info-box {
            border-left: 4px solid #007bff;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 4px 4px 0;
            border: 1px solid #e0e0e0;
        }

        .info-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .contact-info {
            padding: 25px;
            border-radius: 8px;
            margin: 25px 0;
            border: 1px solid #e0e0e0;
        }

        .contact-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .contact-icon {
            width: 16px;
            height: 16px;
            margin-right: 10px;
            color: #007bff;
        }

        .contact-link {
            color: #007bff;
            text-decoration: none;
        }

        .contact-link:hover {
            text-decoration: underline;
        }

        .business-hours {
            margin-top: 15px;
        }

        .hours-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            font-size: 14px;
        }

        .footer {
            color: #666;
            padding: 30px 20px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .footer-text {
            font-size: 14px;
            margin-bottom: 15px;
        }

        .social-links {
            margin: 20px 0;
        }

        .social-link {
            display: inline-block;
            margin: 0 10px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .social-link:hover {
            color: #0056b3;
        }

        .copyright {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
        }

        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }
            
            .content-section {
                padding: 20px 15px;
            }
            
            .contact-info {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            ' . (!empty($company_details['logo_url']) ? '<img src="' . htmlspecialchars($company_details['logo_url']) . '" alt="' . htmlspecialchars($company_details['company_name']) . '" class="logo-image">' : '') . '
            <h1 class="header-title">' . processEmailTemplate($templates['header_title'], $variables) . '</h1>
            <p class="header-subtitle">' . processEmailTemplate($templates['header_subtitle'], $variables) . '</p>
        </div>

        <!-- Main Content -->
        <div class="content-section">
            <div class="greeting">' . processEmailTemplate($templates['personal_greeting'], $variables) . '</div>
            
            <div class="message-text">
                ' . nl2br(processEmailTemplate($templates['main_message'], $variables)) . '
            </div>

            <div class="info-box">
                <div class="info-title">' . processEmailTemplate($templates['submission_details_title'], $variables) . '</div>
                <strong>' . processEmailTemplate($templates['submission_subject_label'], $variables) . '</strong> ' . htmlspecialchars($variables['subject']) . '<br>
                <strong>' . processEmailTemplate($templates['submission_date_label'], $variables) . '</strong> ' . $variables['current_datetime'] . '<br>
                <strong>' . processEmailTemplate($templates['response_time_label'], $variables) . '</strong> Within ' . processEmailTemplate($templates['response_time'], $variables) . '
            </div>

            <div class="message-text">
                ' . processEmailTemplate($templates['closing_message'], $variables) . '
            </div>

            <!-- Contact Information -->
            <div class="contact-info">
                <div class="contact-title">' . processEmailTemplate($templates['contact_info_title'], $variables) . '</div>
                
                <div class="contact-item">
                    <svg class="contact-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                    <a href="mailto:' . htmlspecialchars($company_details['email']) . '" class="contact-link">' . htmlspecialchars($company_details['email']) . '</a>
                </div>
                
                <div class="contact-item">
                    <svg class="contact-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                    </svg>
                    <a href="tel:' . htmlspecialchars(str_replace(' ', '', $company_details['phone'])) . '" class="contact-link">' . htmlspecialchars($company_details['phone']) . '</a>
                </div>
                
                ' . (!empty($company_details['website']) ? '
                <div class="contact-item">
                    <svg class="contact-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <a href="' . htmlspecialchars($company_details['website']) . '" class="contact-link" target="_blank">' . htmlspecialchars($company_details['website']) . '</a>
                </div>
                ' : '') . '

                ' . (!empty($company_details['business_hours']) ? '
                <div class="business-hours">
                    <div style="font-weight: 600; margin-bottom: 10px; color: #333;">' . processEmailTemplate($templates['business_hours_title'], $variables) . '</div>
                    ' . (!empty($company_details['business_hours']['monday_friday']) ? '<div class="hours-item"><span>Monday - Friday:</span><span>' . htmlspecialchars($company_details['business_hours']['monday_friday']) . '</span></div>' : '') . '
                    ' . (!empty($company_details['business_hours']['saturday']) ? '<div class="hours-item"><span>Saturday:</span><span>' . htmlspecialchars($company_details['business_hours']['saturday']) . '</span></div>' : '') . '
                    ' . (!empty($company_details['business_hours']['sunday']) ? '<div class="hours-item"><span>Sunday:</span><span>' . htmlspecialchars($company_details['business_hours']['sunday']) . '</span></div>' : '') . '
                </div>
                ' : '') . '
            </div>
        </div>

        <!-- Footer -->
        <div class="footer" style="background: transparent;">
            <div class="footer-text">
                ' . processEmailTemplate($templates['footer_thank_you'], $variables) . '
            </div>
            
            ' . (!empty($company_details['social_media']) ? '
            <div class="social-links">
                ' . (!empty($company_details['social_media']['facebook']) ? '<a href="' . htmlspecialchars($company_details['social_media']['facebook']) . '" class="social-link" target="_blank">Facebook</a>' : '') . '
                ' . (!empty($company_details['social_media']['linkedin']) ? '<a href="' . htmlspecialchars($company_details['social_media']['linkedin']) . '" class="social-link" target="_blank">LinkedIn</a>' : '') . '
                ' . (!empty($company_details['social_media']['twitter']) ? '<a href="' . htmlspecialchars($company_details['social_media']['twitter']) . '" class="social-link" target="_blank">Twitter</a>' : '') . '
            </div>
            ' : '') . '
            
            <div class="copyright">
                ' . processEmailTemplate($templates['copyright_text'], $variables) . '
            </div>
        </div>
    </div>
</body>
</html>';

    return $html;
}

/**
 * Send test email
 */
function sendTestEmail($to = 'info@dimath.lk') {
    $subject = 'Test Email from Dimath Group - ' . date('Y-m-d H:i:s');
    
    $message = "This is a test email from Dimath Group website using PHPMailer.\n\n";
    $message .= "Test Details:\n";
    $message .= "- Sent from: " . env('FROM_NAME', 'Dimath Group') . " <" . env('FROM_EMAIL', 'info@dimath.lk') . ">\n";
    $message .= "- SMTP Host: " . env('SMTP_HOST', 'premium5.web-hosting.com') . "\n";
    $message .= "- SMTP Port: " . env('SMTP_PORT', '587') . "\n";
    $message .= "- SMTP Username: " . env('SMTP_USERNAME', 'leads@solluton.com') . "\n";
    $message .= "- SMTP Encryption: " . env('SMTP_ENCRYPTION', 'tls') . "\n";
    $message .= "- Test Time: " . date('Y-m-d H:i:s') . "\n";
    $message .= "- Server: " . ($_SERVER['SERVER_NAME'] ?? 'localhost') . "\n";
    $message .= "- PHP Version: " . phpversion() . "\n";
    $message .= "- PHPMailer: Enabled\n\n";
    $message .= "If you receive this email, the SMTP configuration is working correctly!\n\n";
    $message .= "Best regards,\n";
    $message .= "Dimath Sports Team";
    
    return sendEmail($to, $subject, $message, false);
}
?>
