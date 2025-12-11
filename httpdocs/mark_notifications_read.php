<?php
$servername = "johnny.heliohost.org";
$username   = "sphinx0945_dev"; 
$password   = "Dev12311";      
$dbname     = "sphinx0945_studentlist";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error']);
    exit;
}

$sql = "UPDATE registration_notifications SET is_read = 1 WHERE is_read = 0";
if ($conn->query($sql)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}

$conn->close();
?>
