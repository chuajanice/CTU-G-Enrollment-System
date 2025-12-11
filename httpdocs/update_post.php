<?php
include 'config.php';

$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];

$sql = "UPDATE updates SET title = ?, description = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $title, $description, $id);

if ($stmt->execute()) {
  header("Location: pupdates.php?updated=1");
  exit;
} else {
  echo "Error updating record: " . $conn->error;
}
?>
