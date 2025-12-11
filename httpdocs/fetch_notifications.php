<?php
header('Content-Type: application/json');

$servername = "johnny.heliohost.org";
$username   = "sphinx0945_dev"; 
$password   = "Dev12311";      
$dbname     = "sphinx0945_studentlist";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['count' => 0, 'notifications' => [], 'error' => 'Connection failed']);
    exit;
}

$query = "SELECT * FROM registration_notifications ORDER BY id DESC LIMIT 20";
$result = $conn->query($query);

$notifications = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}

$count_query = "SELECT COUNT(*) AS unread_count FROM registration_notifications WHERE is_read = 0";
$count_result = $conn->query($count_query);
$count = 0;

if ($count_result) {
    $row = $count_result->fetch_assoc();
    $count = $row['unread_count'];
}

echo json_encode(['count' => $count, 'notifications' => $notifications]);

$conn->close();
?>



