<?php
$conn = new mysqli("johnny.heliohost.org", "sphinx0945_dev", "Dev12311", "sphinx0945_studentlist");
if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? '';

if ($id && $status) {
    $stmt = $conn->prepare("UPDATE list SET workflow_status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        echo "Workflow status updated successfully.<br>";

       
        if ($status === 'Done') {
            $_POST['id'] = $id;
            $_POST['status'] = $status;
            include 'registerstudent.php';
        }

    } else {
        echo "Error updating workflow_status: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>