<?php
if (!isset($conn)) {
    // Make sure $conn (mysqli connection) exists
    error_log("log_login.php: No database connection found.");
    return;
}

if (!empty($user)) { // $user is the authenticated username
    $device = $_SERVER['HTTP_USER_AGENT']; // browser/device info
    $ip = $_SERVER['REMOTE_ADDR'];         // user IP


    $stmt = $conn->prepare("
        INSERT INTO login_logs (username, device_info, ip_address, login_time)
        VALUES (?, ?, ?, UTC_TIMESTAMP())
    ");

    if ($stmt) {
        $stmt->bind_param("sss", $user, $device, $ip);
        $stmt->execute();
    } else {
        error_log("log_login.php: Failed to prepare statement: " . $conn->error);
    }
}
?>
