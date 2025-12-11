<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Added Successfully</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
   <div class="success-position">
        <div class="success-box">
            <button class="back-btn" onclick="window.location.href='admin.php'"><i class="fa fa-arrow-left"></i></button><br><br>
            <h2>New student has been added.</h2><br>
            
        </div>
	</div>
</body>
</html>
