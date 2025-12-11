<?php
$servername = "johnny.heliohost.org";
$username = "sphinx0945_dev"; 
$password = "Dev12311";     
$dbname = "sphinx0945_studentlist";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Collect Form Data ---
$first_name = $_POST['first_name'] ?? '';
$middle_name = $_POST['middle_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$address = $_POST['address'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$gender = $_POST['gender'] ?? '';
$email = $_POST['email'] ?? '';
$contact = $_POST['contact'] ?? '';
$program = $_POST['program'] ?? '';
$year = $_POST['year'] ?? '';
$academic_status = $_POST['academic_status'] ?? '';
$student_status = $_POST['student_status'] ?? '';
$semester = $_POST['semester'] ?? '';

// --- Validate Required Fields ---
if (
    empty($first_name) || empty($last_name) || empty($birthdate) ||
    empty($gender) || empty($email) || empty($contact) ||
    empty($program) || empty($year) || empty($academic_status)
) {
    echo "Error: Please fill in all required fields.";
    exit();
}

// --- Insert Data into Database ---
$sql = "INSERT INTO list 
        (first_name, middle_name, last_name, address, birth_date, gender, email, contactno, program, year, academicstatus, studentstatus, semester)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssssssssss",
    $first_name,
    $middle_name,
    $last_name,
    $address,
    $birthdate,
    $gender,
    $email,
    $contact,
    $program,
    $year,
    $academic_status,
    $student_status,
    $semester
);

if ($stmt->execute()) {
    $full_name = htmlspecialchars($first_name . ' ' . $last_name);
    $message = "New student registered: " . $full_name; 

    $notif_sql = "INSERT INTO registration_notifications (message, is_read) VALUES (?, 0)";
    $notif_stmt = $conn->prepare($notif_sql);
    $notif_stmt->bind_param("s", $message);
    $notif_stmt->execute();
    $notif_stmt->close();

    header("Location: success.html");
    exit();
} else {
    echo "Error saving registration: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
