<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'])) {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    if ($action === 'transfer') {
        $stmt = $conn->prepare("SELECT first_name, middle_name, last_name, address, birthdate, gender, email, contactno, program, year, academicstatus, studentstatus, semester 
                                FROM registered WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row) {
            $stmt2 = $conn->prepare("INSERT INTO list 
                (first_name, middle_name, last_name, address, birth_date, gender, email, contactno, program, year, academicstatus, studentstatus, semester) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt2->bind_param("sssssssssssss",
                $row['first_name'],
                $row['middle_name'],
                $row['last_name'],
                $row['address'],
                $row['birthdate'],
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
                $stmt3 = $conn->prepare("DELETE FROM registered WHERE id=?");
                $stmt3->bind_param("i", $id);
                $stmt3->execute();
                $stmt3->close();
            }
            $stmt2->close();
        }
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM registered WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();
    echo "Action completed";
} else {
    echo "Invalid request.";
}
?>