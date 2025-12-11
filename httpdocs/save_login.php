<?php
include 'config.php';

$user = $_POST['user'];       // from login
$device = $_POST['device'];   // detected device
$login_date = date("Y-m-d H:i:s");

$conn->query("UPDATE login_history SET status='Logged Out', logout_time=NOW() WHERE status='Active' AND user='$user'");

$stmt = $conn->prepare("INSERT INTO login_history (user, device, login_date, status) VALUES (?, ?, ?, 'Active')");
$stmt->bind_param("sss", $user, $device, $login_date);
$stmt->execute();
$stmt->close();

echo "success";
?>