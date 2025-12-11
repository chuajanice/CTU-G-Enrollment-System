<?php
include 'config.php';

$sql = "DELETE FROM registration_notifications WHERE id < 100000";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "Notifications cleared"]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
}

$conn->close();
?>