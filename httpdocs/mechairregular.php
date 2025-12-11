<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: index.html");
    exit;
}

// Database connection

$conn = new mysqli("johnny.heliohost.org", "sphinx0945_dev", "Dev12311", "sphinx0945_studentlist");
if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$program = 'DMT';
$academic_status = 'Irregular';

$sql = "SELECT * FROM registered
        WHERE program=? AND academicstatus=?
        ORDER BY last_name ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $program, $academic_status);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DMT - Irregulars</title>
  <link rel="stylesheet" href="style.css"/>
  <link rel="stylesheet" href="admin.css" />
  <link rel="stylesheet" href="print.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="dashboard">
    <header class="admin-header">
      <div class="admin-profile">
        <div class="avatar">🎓</div>
        <h3>DMT - Irregulars</h3>
      </div>

      <div class="icons">
        <button onclick="window.location.href='mecha.html'" title="Back">
          <i class="fa fa-arrow-left"></i>
        </button>
      </div>
    </header>

    <section class="table-container">
      <table>
          <thead>
              <tr>
                  <th>#</th>
                  <th>Full Name</th>
                  <th>Program</th>
                  <th>Year</th>
                  <th>Semester</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Status</th>
              </tr>
          </thead>
          <tbody id="student-table-body">
          <?php
          $i = 1;
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()){
    $fullname = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];

    echo '<tr>
            <td>'.$i.'</td>
            <td>'.htmlspecialchars($fullname).'</td>
            <td>'.htmlspecialchars($row['program']).'</td>
            <td>'.htmlspecialchars($row['year']).'</td>
            <td>'.htmlspecialchars($row['semester']).'</td>
            <td>'.htmlspecialchars($row['email']).'</td>
            <td>'.htmlspecialchars($row['contactno']).'</td>
            <td>'.htmlspecialchars($row['academicstatus']).'</td>
            <td class="action-column">
                <select class="action-dropdown" data-id="'.htmlspecialchars($row['id']).'">
                    <option value="">-- Select Action --</option>
                    <option value="transfer">Transfer to List</option>
                    <option value="delete">Delete</option>
                </select>
            </td>
          </tr>';
    $i++;
}
          } else {
              echo "<tr><td colspan='9'>No Irregular DMT students found.</td></tr>";
          }
          
          $stmt->close();
          $conn->close();
          ?>
          </tbody>
      </table>

    </section>
	  
	  <button class="print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print / Save PDF</button>
	
	  <button class="clear-btn" onclick="confirmClear()">Clear List</button>

	  
  </div>
	<script>
		document.querySelectorAll('.action-dropdown').forEach(dropdown => {
  dropdown.addEventListener('change', function() {
    const studentId = this.dataset.id;
    const action = this.value;

    if (!action) return;

    const confirmMsg = (action === 'delete')
      ? 'Are you sure you want to DELETE this student?'
      : 'Transfer this student to the list?';

    if (!confirm(confirmMsg)) {
      this.value = ''; // reset if cancelled
      return;
    }

    fetch('action.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `id=${encodeURIComponent(studentId)}&action=${encodeURIComponent(action)}`
    })
    .then(r => r.text())
    .then(() => location.reload());
  });
});



	function confirmClear() {
		if (confirm("WARNING: This will permanently delete ALL DMT Irregular students.\n\nAre you sure?")) {
			window.location.href = "clear_dmtirregular.php";
		}
	}
	</script>
</body>
</html>
