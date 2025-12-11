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
    <title>Add Student | Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="loginstyle.css">
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="register-box">
            <button class="back-btn" onclick="window.location.href='admin.php'"><i class="fa fa-arrow-left"></i></button><br><br>
            <h2>Add Student</h2>
            
            <form method="post" action="addingstudent.php">
                
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="middle_name" placeholder="Middle Name">
                <input type="text" name="last_name" placeholder="Last Name" required>

                <select id="address" name="address" required>
                  <option value="" disabled selected>Address</option>
                </select>

                <input type="text" id="birthdate" name="birthdate" placeholder="Birth Date" onfocus="(this.type='date')" required>

                <input type="email" name="email" placeholder="Email Address" required>
                <input type="tel" name="contact" placeholder="Contact No." 
       required pattern="^(09[0-9]{9}|\+639[0-9]{9})$"
       title="Format: 09XXXXXXXXX or +639XXXXXXXXX">


                <select name="gender" required>
                    <option value="" disabled selected>Gender</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                    <option value="Prefer not to say">Prefer not to say</option>
                </select>

                <select id="program" name="program" required>
                    <option value="" disabled selected>Program</option>
                    <option value="BSIT">BSIT</option>
                    <option value="BIT-CT">BIT-CT</option>
					<option value="BTLED-ICT">BTLED-ICT</option>
					<option value="BSIE">BSIE</option>
					<option value="DMT">DMT</option>
                </select>

                <select id="year" name="year" required>
                    <option value="" disabled selected>Year Level</option>
                    <option value="1st">1st Year</option>
                    <option value="2nd">2nd Year</option>
                    <option value="3rd">3rd Year</option>
                    <option value="4th" id="fourth">4th Year</option>
                </select>

                <select name="academic_status" required>
                    <option value="" disabled selected>Academic Status</option>
                    <option value="Regular">Regular</option>
                    <option value="Irregular">Irregular</option>
                </select>

                <select name="student_status" required>
                    <option value="" disabled selected>Student Status</option>
                    <option value="New">New Student</option>
                    <option value="Transferee">Transferee</option>
                    <option value="Returnee">Returnee</option>
                    <option value="Old Student">Continuee</option>
                </select>
                
                <select name="semester" required>
                    <option value="" disabled selected>Semester</option>
                    <option value="1st Semester">1st Semester</option>
                    <option value="2nd Semester">2nd Semester</option>
                </select>

                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
	
    <script src="register.js"></script>
	
	<script>
	document.getElementById("program").addEventListener("change", function () {
		const isDMT = this.value === "DMT";
		const fourthYear = document.getElementById("fourth");

		fourthYear.disabled = isDMT;

		// If 4th year is currently selected while switching to DMT, reset year selection
		if (isDMT && document.getElementById("year").value === "4th") {
			document.getElementById("year").value = "";
		}
	});
	</script>
</body>
</html>
