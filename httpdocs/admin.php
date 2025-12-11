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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | Admin Panel</title>
  <link rel="stylesheet" href="style.css"/>
  <link rel="stylesheet" href="admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="dashboard">
    <header class="admin-header">
      <div class="admin-profile">
        <div class="avatar"><i class="fa fa-user"></i></div>
        <h3>Dashboard</h3>
      </div>
      <div class="icons">
        
        <button onclick="window.location.href='adminhome.php'" title="Back"><i class="fa fa-arrow-left"></i></button>
      </div>
    </header>
		

	  <input 
			type="text" 
			id="searchInput" 
			class="search-bar" 
			placeholder="Search something..."
		>
	
	  
    <section class="table-container">
      <table>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Program</th>
            <th>Year</th>
            <th>Semester</th>
            <th>Registration Date</th>
			<th>Academic Status</th>
            <th>Workflow</th>
          </tr>
        </thead>
        <tbody id="student-table">
          <?php include 'fetchlist.php'; ?>
        </tbody>
      </table>
    </section>
	  <button class="clear-btn" onclick="window.location.href='addstudent.php'">Add Student</button>
	  <button class="clear-btn" onclick="confirmClear()">Clear List</button>
	  
  </div>
	
<script>
    // --- Initial Workflow Binding (Runs once on page load) ---
    function bindWorkflowEvents() {
        document.querySelectorAll('.workflow-dropdown').forEach(dropdown => {
            // Remove any existing listener to prevent double-binding
            dropdown.removeEventListener('change', updateWorkflow); 
            dropdown.addEventListener('change', updateWorkflow);
        });
    }

    // --- Initial Details Expander Binding (Runs once on page load) ---
    function bindDetailsEvents() {
        document.querySelectorAll('.expand-details').forEach(button => {
            // Remove any existing listener to prevent double-binding
            button.removeEventListener('click', toggleDetails); 
            button.addEventListener('click', toggleDetails);
        });
    }

    // --- Workflow Update Function ---
    function updateWorkflow() {
        let studentId = this.dataset.id;
        let status = this.value;

        fetch('update_workflow.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${studentId}&status=${status}`
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            // location.reload(); // Removed to rely on AJAX update, but keeping for reference if needed
        });
    }

    // --- Details Toggle Function ---
    function toggleDetails() {
        const rowId = this.dataset.id;
        // The details row is the *next sibling* of the main table row
        const details = document.getElementById('details-' + rowId); 
        details.classList.toggle('show');
        // Optionally change button text/icon
        this.innerHTML = details.classList.contains('show') ? '▲' : '▼'; 
    }


    // --- Search Input Listener (The main fix is here) ---
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let query = this.value;

        fetch('search.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'query=' + encodeURIComponent(query)
        })
        .then(response => response.text())
        .then(data => {
            // 1. Update the table content
            document.getElementById('student-table').innerHTML = data;

            // 2. RE-BIND the event listeners for ALL newly loaded elements
            bindWorkflowEvents();
            bindDetailsEvents();
        });
    });

    // --- Execute initial bindings when the page loads ---
    bindWorkflowEvents();
    bindDetailsEvents();
	
	function confirmClear() {
		if (confirm("WARNING: This will permanently delete ALL the list in DASHBOARD.\n\nAre you sure?")) {
			window.location.href = "clear_dashboard.php";
		}
	}
</script>

  <script src="login.js"></script>
</body>
</html>

