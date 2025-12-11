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
  <title>Admin Home | CTU - Ginatilan</title>
   <link rel="stylesheet" href="home.css">
   <link rel="stylesheet" href="style.css">
	
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
	
	<style>
		.icons {
			display: flex;
			align-items: center;
			gap: 10px;
		}

		/* wrapper must be relative */
		.hamburger-wrap {
			position: relative;
		}

		/* hamburger hidden by default */
		.hamburger {
			display: none;
			font-size: 26px;
			background: none;
			border: none;
			cursor: pointer;
		}

		/* dropdown now positions under hamburger */
		.dropdown {
			display: none;
			position: absolute;
			top: 40px; /* directly below hamburger */
			right: 0;
			left: auto;  
			background: white;
			border-radius: 10px;
			padding: 10px 0;
			width: 160px;
			box-shadow: 0 4px 12px rgba(0,0,0,0.15);
			z-index: 200;
		}

		.dropdown a {
			display: block;
			padding: 12px 20px;
			text-decoration: none;
			color: #222;
		}

		.dropdown a:hover {
			background: #eee;
		}

		/* RESPONSIVE */
		@media (max-width: 700px) {

			/* hide only history, dashboard, logout */
			.icons > button:nth-child(n+2):not(:last-child) {
				display: none;
			}

			/* show hamburger */
			.hamburger {
				display: block;
			}
		}

	</style>

</head>
<body>

  <div class="dashboard">
    <header class="admin-header">
      <div class="admin-profile">
        <div class="avatar"><i class="fa fa-user"></i></div>
        <h3>HOME</h3>
      </div>

      <div class="icons">
        <div class="notification-container">
            <button id="notifBtn" title="Notifications">
                <i class="fa fa-bell"></i>
                <span id="notifCount" class="badge"></span>
            </button>

            <div id="notifDropdown" class="notif-dropdown">
    			<div style="display: flex; justify-content: space-between; align-items: center;">
  					<h4 style="margin: 0;">Notifications</h4>
  					<button id="clearNotifBtn" style="padding: 5px 8px; font-size: 13px; margin-right: 10px;">Clear</button>
				</div>
    			<ul id="notifList"></ul>
			</div>
        </div>
        <button onclick="window.location.href='history.php'" title="Login History"><i class="fa fa-scroll"></i></button>
        <button onclick="window.location.href='admin.php'" title="Dashboard"><i class="fa fa-folder-open"></i></button> 
    	<button onclick="window.location.href='logout.php'" title="Logout"><i class="fas fa-sign-out-alt"></i></button>
		<div class="hamburger-wrap">
			<button class="hamburger" id="hamburgerBtn">☰</button>

			<div class="dropdown" id="dropdownMenu">
				<a href="history.php">History Logs</a>
				<a href="admin.php">Dashboard</a>
				<a href="logout.php">Logout</a>
			</div>
		</div>
      </div>
		
    </header>

    <section class="home-content">
      <h1>Hello, Admin!</h1>
      <p>Manage and monitor all essential sections of your system below.</p>

      <div class="cards">
        <div class="card" onclick="window.location.href='pupdates.php'">
          <h2>📰 Updates</h2>
          <p>Post announcements, news, and important notices.</p>
        </div>

        <div class="card" onclick="window.location.href='programs.php'">
         <h2>🎓 Programs</h2>
         <p>View and manage student lists under different programs.</p>
        </div>
        
      </div>
    </section>
  </div>

  <script>
	  
	  
	  const hamBtn = document.getElementById("hamburgerBtn");
    const dropdown = document.getElementById("dropdownMenu");

    hamBtn.addEventListener("click", () => {
        dropdown.style.display =
            dropdown.style.display === "block" ? "none" : "block";
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function (e) {
        if (!hamBtn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = "none";
        }
    });
	  
	  


	  
const notifBtn = document.getElementById('notifBtn');
const notifCount = document.getElementById('notifCount');
const notifList = document.getElementById('notifList');
const notifDropdown = document.getElementById('notifDropdown');
const clearNotifBtn = document.getElementById('clearNotifBtn');

clearNotifBtn.addEventListener('click', () => {
  // Call your PHP clear script
  fetch('clear_notifications.php')
    .then(res => res.json()) // expecting JSON {success:true/false, message:"..."}
    .then(data => {
      if (data.success) {
        // Clear the list visually
        notifList.innerHTML = '<li>No new notifications</li>';
        notifCount.textContent = '';
        // Reload page if you want a full refresh
        location.reload();
      } else {
        alert(data.message || "Failed to clear notifications");
      }
    })
    .catch(err => {
      console.error("Error clearing notifications:", err);
      alert("Error clearing notifications");
    });
});

// Toggle dropdown and mark as read
notifBtn.addEventListener('click', () => {
  notifDropdown.classList.toggle('show');

  // Only mark read if we are OPENING the dropdown and there are unread items
  if (notifDropdown.classList.contains('show') && notifCount.textContent !== '') {
    
    fetch('mark_notifications_read.php') 
      .then(res => res.json())
      .then(data => {
        if(data.status === 'success'){
            notifCount.textContent = ''; // Clear badge immediately on success
        }
      })
      .catch(err => console.error("Error marking read:", err));
  }
});

function fetchNotifications() {
  fetch('fetch_notifications.php')
    .then(res => res.json())
    .then(data => {
      notifList.innerHTML = ''; // Clear the current list

      // Update badge count
      notifCount.textContent = data.count > 0 ? data.count : ''; // If no notifications, hide the badge

      if (data.notifications && data.notifications.length > 0) {
        data.notifications.forEach(item => {
          const li = document.createElement('li');
          // Add a class if it's unread for styling
          if (item.is_read == 0) {
            li.style.fontWeight = "bold";
            li.classList.add("unread");
          }
          li.textContent = item.message; // Assuming your DB column is 'message'
          notifList.appendChild(li);
        });
      } else {
        // If no notifications, show this message
        notifList.innerHTML = '<li>No new notifications</li>';
      }
    })
    .catch(error => console.error('Error fetching notifications:', error));
}


// Start the interval
setInterval(fetchNotifications, 30000); 
// Run once immediately on load
fetchNotifications();
</script>

<script src="login.js"></script>

</body>
</html>