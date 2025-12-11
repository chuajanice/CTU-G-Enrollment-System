<?php
include "config.php";

// Backup current history
/*$conn->query("INSERT INTO login_history_backup (user, device, login_date, logout_time, status, backup_date)
              SELECT user, device, login_date, logout_time, status, NOW() FROM login_history");*/

// Clear main table
$conn->query("TRUNCATE TABLE login_logs");

// Show alert and reload page
echo "<script>
        alert('History cleared!');
        window.location.href = 'history.php';
      </script>";
?>