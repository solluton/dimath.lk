<?php
/**
 * Timezone Helper Functions
 * Provides consistent timezone handling for Sri Lanka (Asia/Colombo)
 */

// Ensure timezone is set to Sri Lanka
if (date_default_timezone_get() !== 'Asia/Colombo') {
    date_default_timezone_set('Asia/Colombo');
}

/**
 * Get current Sri Lanka time
 */
function getSriLankaTime($format = 'Y-m-d H:i:s') {
    return date($format);
}

/**
 * Convert UTC timestamp to Sri Lanka time
 */
function convertToSriLankaTime($utcTimestamp, $format = 'Y-m-d H:i:s') {
    $date = new DateTime($utcTimestamp, new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone('Asia/Colombo'));
    return $date->format($format);
}

/**
 * Convert Sri Lanka time to UTC timestamp
 */
function convertToUTC($sriLankaTime) {
    $date = new DateTime($sriLankaTime, new DateTimeZone('Asia/Colombo'));
    $date->setTimezone(new DateTimeZone('UTC'));
    return $date->format('Y-m-d H:i:s');
}

/**
 * Get Sri Lanka timezone offset
 */
function getSriLankaOffset() {
    $date = new DateTime('now', new DateTimeZone('Asia/Colombo'));
    return $date->format('P'); // Returns +05:30
}

/**
 * Format date for display in Sri Lanka timezone
 */
function formatSriLankaDate($timestamp, $format = 'M j, Y g:i A') {
    if (empty($timestamp) || $timestamp === '0000-00-00 00:00:00') {
        return '-';
    }
    
    try {
        $date = new DateTime($timestamp);
        $date->setTimezone(new DateTimeZone('Asia/Colombo'));
        return $date->format($format);
    } catch (Exception $e) {
        // Return '-' for invalid timestamps
        return '-';
    }
}

/**
 * Get current Sri Lanka date for database insertion
 */
function getCurrentSriLankaTime() {
    return getSriLankaTime('Y-m-d H:i:s');
}

/**
 * Check if timezone is properly configured
 */
function isTimezoneConfigured() {
    return date_default_timezone_get() === 'Asia/Colombo';
}

/**
 * Get timezone info for debugging
 */
function getTimezoneInfo() {
    return [
        'php_timezone' => date_default_timezone_get(),
        'sri_lanka_time' => getSriLankaTime(),
        'offset' => getSriLankaOffset(),
        'is_configured' => isTimezoneConfigured()
    ];
}
?>
