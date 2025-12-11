<?php
session_start();

/* Block access if not logged in */
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: index.html");
    exit;
}

/* Connect to database */
$conn = new mysqli("johnny.heliohost.org", "sphinx0945_dev", "Dev12311", "sphinx0945_studentlist");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* Delete ONLY BSIT 1st-year students */
$sql = "DELETE FROM registered WHERE program='BTLED-ICT' AND year='2nd'";

if ($conn->query($sql) === TRUE) {
    $message = "BTLED-ICT 2nd-year student list cleared successfully!";
} else {
    $message = "Error clearing list: " . $conn->error;
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cleared</title>
    <meta http-equiv="refresh" content="2; URL=btled-ict2.php">
    <style>
        body {
            font-family: Arial;
            text-align: center;
            padding-top: 40px;
        }
    </style>
</head>
<body>
    <h2><?php echo $message; ?></h2>
    <p>Redirecting back to BTLED-ICT 2nd Year page...</p>
</body>
</html>
