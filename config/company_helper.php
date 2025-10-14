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
    
    $parts = [];
    if (!empty($address['street'])) $parts[] = $address['street'];
    if (!empty($address['city'])) $parts[] = $address['city'];
    if (!empty($address['postal_code'])) $parts[] = $address['postal_code'];
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
?>
