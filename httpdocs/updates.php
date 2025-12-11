<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CTU - Ginatilan</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header>
    <div class="logo">
      <img src="CTU_new_logo.png" alt="CTU Ginatilan Logo" />
      <div class="logo-text"><a href="index.html">CTU - Ginatilan</a></div>
    </div>

    <button class="menu-toggle" onclick="toggleMenu()">☰</button>

    <nav id="nav-menu">
      <a href="course.html">Courses</a>
      <a href="process.html">Process</a>
      <a href="updates.php">Updates</a>
      <a href="about.html">About</a>
      <a href="login.html"><button class="login-btn">LOG IN</button></a>
    </nav>
  </header>
	
  <div class="updates-container">
		<h1>Updates</h1>

		<div class="post-box" id="displayPost">
			<?php
				include 'fetch_posts.php';
			?>
		</div>
	</div>

  

  <footer>
    ©2025 Enrollment System - BSIT-2A |
    <a href="https://www.facebook.com/ctuginatilanextensioncampus" target="_blank">Facebook</a> | 
    <a href="https://3dmodel.helioho.st" target="_blank">3D CTU Building Model</a>
  </footer>

  <script>
    function toggleMenu() {
      const nav = document.getElementById('nav-menu');
      nav.classList.toggle('active');
    }
  </script>
  <script src="script.js"></script>
</body>
</html>

