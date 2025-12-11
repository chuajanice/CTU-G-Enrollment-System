<?php
include 'config.php';

date_default_timezone_set('Asia/Manila');

$result = $conn->query("SELECT * FROM login_logs ORDER BY login_time DESC");
?>
