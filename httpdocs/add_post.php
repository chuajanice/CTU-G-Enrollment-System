<?php
include 'config.php';

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';

if (!empty($title) && !empty($description)) {
  $stmt = $conn->prepare("INSERT INTO updates (title, description) VALUES (?, ?)");
  $stmt->bind_param("ss", $title, $description);
  $stmt->execute();
  echo "success";
	header("Location: adminhome.php?");
  $stmt->close();
} else {
  echo "error";
}

$conn->close();
?>
