<?php

// Redirect function
function redirect($path) {
    header("Location: " . SITE_ROOT . $path);
    exit();
}

// Convert date to "YYYY-MM-DD" format (for DB)
function dateForDb($date) {
    return date("Y-m-d", strtotime($date));
}

// Convert date to "DD-MM-YYYY" format (for user)
function dateForUser($date) {
    return date("d-m-Y", strtotime($date));
}

// Get current timestamp
function timestamp() {
    return date("Y-m-d H:i:s"); // Inayos ang format (dapat may dalawang digit sa seconds)
}

// Time Ago function
function timeAgo($dateTime) {
    $time = strtotime($dateTime);
    $current = time();
    $seconds = $current - $time;
    
    if ($seconds < 60) {
        return ($seconds == 0) ? 'now' : $seconds . 's ago';
    } elseif ($seconds < 3600) {
        return round($seconds / 60) . 'm ago';
    } elseif ($seconds < 86400) {
        return round($seconds / 3600) . 'h ago';
    } elseif ($seconds < 604800) {
        return round($seconds / 86400) . 'd ago';
    } elseif ($seconds < 31536000) {
        return date("M j", $time);
    } else {
        return date("j M Y", $time);
    }
}
?>
