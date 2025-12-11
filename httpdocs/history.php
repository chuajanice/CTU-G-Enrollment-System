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
<title>History Logs | Admin Panel</title>
<link rel="stylesheet" href="history.css">
</head>
<body>
<div class="history-container">
  <header>
    <h2>Admin Login History</h2>
    <button onclick="window.location.href='adminhome.php'">Back</button>
  </header>

	<div class="table-responsive">
	  <table>
		<thead>
		  <tr>
			<th>User</th>
			<th>Device Info</th>
			<th>Ip Address</th>
			<th>Login Date</th>
		  </tr>
		</thead>
		<tbody>
		  <?php
			include 'fetchhistory.php';
			while ($row = $result->fetch_assoc()) {
				$login_time = new DateTime($row['login_time'], new DateTimeZone('UTC'));

				$login_time->setTimezone(new DateTimeZone('Asia/Manila'));

			 echo "<tr>
				<td>".$row['username']."</td>
				<td>".$row['device_info']."</td>
				<td>".$row['ip_address']."</td>
				<td>".$login_time->format("M d, Y h:i:s A")."</td>
			</tr>";
			}
		?>
		</tbody>
	  </table>
		
	</div>
  

  <div class="actions">
    <button onclick="window.location.href='clear_history.php'">🗑 Clear History</button>
  </div>
</div>
</body>
</html>