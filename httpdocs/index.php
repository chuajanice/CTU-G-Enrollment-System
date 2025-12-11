<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Content-Type: text/plain");

$host = "johnny.heliohost.org";
$dbname = "sphinx0945_studentlist";
$username = "sphinx0945_dev";
$password = "Dev12311";
$port = 3306;


$conn = @new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    error_log("DATABASE ERROR: Connection failed: " . $conn->connect_error);
    http_response_code(500);
    exit("An internal server error occurred.");
}

$user = trim($_POST['username'] ?? '');
$pass = trim($_POST['password'] ?? '');

error_log("DEBUG: Attempting login for username: '" . $user . "'");

$stmt = $conn->prepare("SELECT password FROM sphinx0945_studentlist.login WHERE username = ?;");

if (!$stmt) {
    error_log("ERROR: Prepare failed: " . $conn->error);
    exit("Login failed: Could not process request.");
}

$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    error_log("DEBUG: Username '" . $user . "' was FOUND. Stored hash is: " . $row['password']);
    
    if (password_verify($pass, $row['password'])) {
        session_start();
		$_SESSION['authenticated'] = true;
		
		include 'log_login.php';
        error_log("DEBUG: PASSWORD VERIFIED. Login successful.");
        echo "success";
        
    } else {
        error_log("DEBUG: PASSWORD FAILED VERIFICATION. Input password was: '" . $pass . "'");
        echo "Invalid username or password.";
    }
} else {
    error_log("DEBUG: USERNAME NOT FOUND in database for: '" . $user . "'");
    echo "Invalid username or password.";
}

$stmt->close();
$conn->close();
