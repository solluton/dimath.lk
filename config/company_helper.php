<?php
/**
 * Company Details Helper Functions
 * Loads company information from JSON file and provides helper functions
 */

/**
 * Load company details from JSON file
 */
function getCompanyDetails() {
    static $company_details = null;
    
    if ($company_details === null) {
        $json_file = __DIR__ . '/company_details.json';
        
        if (file_exists($json_file)) {
            $json_content = file_get_contents($json_file);
            $company_details = json_decode($json_content, true);
        } else {
            // Fallback data if JSON file doesn't exist
            $company_details = [
                'company_name' => 'Dimath Cinnamon',
                'email' => 'contact@dimathcinnamon.com',
                'phone' => '+94 769 175 175',
                'website' => 'https://dimathcinnamon.com',
                'address' => [
                    'street' => 'Dimath Sports (Private) Limited',
                    'city' => 'Batapola',
                    'postal_code' => '80320',
                    'country' => 'Sri Lanka'
                ]
            ];
        }
    }
    
    return $company_details;
}

/**
 * Get company email
 */
function getCompanyEmail() {
    $details = getCompanyDetails();
    return $details['email'] ?? 'contact@dimathcinnamon.com';
}

/**
 * Get company phone number
 */
function getCompanyPhone() {
    $details = getCompanyDetails();
    return $details['phone'] ?? '+94 769 175 175';
}

/**
 * Get company phone number for href (tel: link)
 */
function getCompanyPhoneHref() {
    $phone = getCompanyPhone();
    // Remove spaces and add tel: prefix
    return 'tel:' . str_replace(' ', '', $phone);
}

/**
 * Get company WhatsApp number
 */
function getCompanyWhatsApp() {
    $details = getCompanyDetails();
    return $details['whatsapp'] ?? '+94 76 426 0260';
}

/**
 * Get company WhatsApp number for href (whatsapp: link)
 */
function getCompanyWhatsAppHref() {
    $whatsapp = getCompanyWhatsApp();
    // Remove spaces and add whatsapp: prefix
    return 'whatsapp:' . str_replace(' ', '', $whatsapp);
}

/**
 * Get company email for href (mailto: link)
 */
function getCompanyEmailHref() {
    $email = getCompanyEmail();
    return 'mailto:' . $email;
}

/**
 * Get company name
 */
function getCompanyName() {
    $details = getCompanyDetails();
    return $details['company_name'] ?? 'Dimath Sports';
}

/**
 * Get company website
 */
function getCompanyWebsite() {
    $details = getCompanyDetails();
    return $details['website'] ?? 'https://dimathcinnamon.com';
}

/**
 * Get company address as formatted string
 */
function getCompanyAddress() {
    $details = getCompanyDetails();
    $address = $details['address'] ?? [];
    
    // Use full_address if available, otherwise build from parts
    if (!empty($address['full_address'])) {
        return $address['full_address'];
    }
    
    $parts = [];
    if (!empty($address['street'])) $parts[] = $address['street'];
    if (!empty($address['area'])) $parts[] = $address['area'];
    if (!empty($address['province'])) $parts[] = $address['province'];
    if (!empty($address['country'])) $parts[] = $address['country'];
    
    return implode(', ', $parts);
}

/**
 * Get social media links
 */
function getSocialMediaLinks() {
    $details = getCompanyDetails();
    return $details['social_media'] ?? [];
}

/**
 * Get Facebook URL
 */
function getFacebookUrl() {
    $social = getSocialMediaLinks();
    return $social['facebook'] ?? '#';
}

/**
 * Get Instagram URL
 */
function getInstagramUrl() {
    $social = getSocialMediaLinks();
    return $social['instagram'] ?? '#';
}

/**
 * Get LinkedIn URL
 */
function getLinkedInUrl() {
    $social = getSocialMediaLinks();
    return $social['linkedin'] ?? '#';
}

/**
 * Get Twitter URL
 */
function getTwitterUrl() {
    $social = getSocialMediaLinks();
    return $social['twitter'] ?? '#';
}

/**
 * Get YouTube URL
 */
function getYouTubeUrl() {
    $social = getSocialMediaLinks();
    return $social['youtube'] ?? '#';
}

/**
 * Get business hours
 */
function getBusinessHours() {
    $details = getCompanyDetails();
    return $details['business_hours'] ?? [
        'monday_friday' => '9:00 AM - 5:00 PM',
        'saturday' => '9:00 AM - 4:00 PM',
        'sunday' => '10:00 AM - 2:00 PM'
    ];
}

/**
 * Get formatted business hours for display
 */
function getFormattedBusinessHours() {
    $hours = getBusinessHours();
    return [
        'Monday - Friday' => $hours['monday_friday'],
        'Saturday' => $hours['saturday'],
        'Sunday' => $hours['sunday']
    ];
}

/**
 * Get company logo URL
 */
function getCompanyLogoUrl() {
    $details = getCompanyDetails();
    return $details['logo_url'] ?? '/images/Dimath-Logo_2.avif';
}

/**
 * Get company description or tagline
 */
function getCompanyDescription() {
    $details = getCompanyDetails();
    return $details['description'] ?? 'A diversified Sri Lankan business group committed to excellence across exports, sports, wellness, pharmaceuticals, agriculture, and fuel services.';
}
?>
