<?php

$servername = "johnny.heliohost.org";
$username = "sphinx0945_dev";
$password = "Dev12311";
$dbname = "sphinx0945_studentlist";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
