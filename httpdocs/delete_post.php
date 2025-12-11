<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: index.html"); 
    exit;
}

include 'config.php';


$id = $_POST['id'] ?? 0;

if ($id && is_numeric($id)) {
    $stmt = $conn->prepare("DELETE FROM updates WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        
        $stmt->close();
        $conn->close();
        header("Location: pupdates.php?status=deleted");
        exit;
    } else {
       
        $stmt->close();
        $conn->close();
        header("Location: pupdates.php?status=delete_error");
        exit;
    }
} else {
    
    $conn->close();
    header("Location: pupdates.php?status=invalid_id");
    exit;
}
?>