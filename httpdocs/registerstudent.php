<?php
include 'config.php';

$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? '';

if ($id && $status === 'Done') {
    $stmt = $conn->prepare("SELECT first_name, middle_name, last_name, address, birth_date, gender, email, contactno, program, year, academicstatus, studentstatus, semester 
                            FROM list WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row) {
        $stmt2 = $conn->prepare("INSERT INTO registered 
            (first_name, middle_name, last_name, address, birthdate, gender, email, contactno, program, year, academicstatus, studentstatus, semester) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param("sssssssssssss",
            $row['first_name'],
            $row['middle_name'],
            $row['last_name'],
            $row['address'],
            $row['birth_date'],     
            $row['gender'],
            $row['email'],
            $row['contactno'],
            $row['program'],
            $row['year'],           
            $row['academicstatus'],
            $row['studentstatus'],
            $row['semester']
        );

        if ($stmt2->execute()) {
            echo "Row transferred successfully.<br>";

            $stmt3 = $conn->prepare("DELETE FROM list WHERE id=?");
            $stmt3->bind_param("i", $id);
            $stmt3->execute();
            $stmt3->close();
        } else {
            echo "Insert failed: " . $stmt2->error;
        }
        $stmt2->close();
    } else {
        echo "No row found for ID $id<br>";
    }
}

$conn->close();
?>