<?php
$password_to_hash1 = 'admin1';
$hashed_password1 = password_hash($password_to_hash1, PASSWORD_DEFAULT);

$password_to_hash2 = 'admin2';
$hashed_password2 = password_hash($password_to_hash2, PASSWORD_DEFAULT);

echo "The secure hash for admin1 is: " . $hashed_password1 . "\n";
echo "The secure hash for admin2 is: " . $hashed_password2 . "\n";
?>
