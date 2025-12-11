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
  <title>Programs Management | Admin Panel</title>
   <link rel="stylesheet" href="home.css">
   <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   <style>
    /* Minor adjustments specific to Programs page */
    .home-content h1 {
      color: #222;
    }

    .home-content p {
      color: #444;
      margin-bottom: 30px;
    }
	   
	.dashboard, .home-content, .cards {
		overflow-x: hidden;
	}
	
	.cards {
		display: flex;
    	flex-wrap: wrap;
	   }
	   

    .card {
      transition: transform 0.3s, background 0.3s, box-shadow 0.3s;
    }

    .card:hover {
      background: #fff7ef;
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .admin-header h3 {
      font-size: 1.5em;
      color: #333;
    }

    /* Ensure proper spacing for mobile header */
    
      .admin-profile {
        gap: 8px;
      }
      .avatar {
        font-size: 26px;
        padding: 8px 12px;
      }
    }
  </style>
</head>
<body>

  <div class="dashboard">
    <header class="admin-header">
      <div class="admin-profile">
        <div class="avatar">🎓</div>
        <h3>PROGRAMS</h3>
      </div>

      <div class="icons"> 
        <button onclick="window.location.href='adminhome.php'" title="Back"><i class="fa fa-arrow-left"></i></button>
      </div>
    </header>

    <section class="home-content">
      <h1>Available Programs</h1>
      <p>Manage and monitor all students who wish to enroll in these programs.</p>

      <div class="cards">
        <div class="card" onclick="window.location.href='BSIT.html'">
         <h2>🎓 BSIT</h2>
         <p>Bachelor of Science in Information Technology</p>
        </div>

        <div class="card" onclick="window.location.href='BIT-CT.html'">
         <h2>🎓 BIT-CT</h2>
         <p>Bachelor of Industrial Technology - Major in Computer Technology</p>
        </div>
		  
		<div class="card" onclick="window.location.href='bsie.html'">
         <h2>🎓 BSIE</h2>
         <p>Bachelor of Science in Industrial Engineering</p>
        </div>

        <div class="card" onclick="window.location.href='btled-ict.html'">
         <h2>🎓 BTLED-ICT</h2>
         <p>Bachelor of Technology and Livelihood Education with a major in Information and Communication Technology</p>
        </div>
		  
		<div class="card" onclick="window.location.href='mecha.html'">
         <h2>🎓 DMT</h2>
         <p>Diploma in Mechatronics Technology leading to BS Mechatronics</p>
        </div>
        
      </div>
    </section>
  </div>

  <script src="login.js"></script>

</body>
</html>
