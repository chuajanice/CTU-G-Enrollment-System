<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: index.html");
    exit;
}

// Set up the target timezone object once
$target_timezone = new DateTimeZone('Asia/Manila');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Updates Editor | Admin Panel</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="posting.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="dashboard">
    <header>
      <div class="admin-info">
        <div class="profile-icon">👤</div>
        <span class="admin-name">UPDATES</span>
      </div>
      <div class="icons">
        <a href="adminhome.php" title="Back"><button><i class="fa fa-arrow-left"></i></button></a>
        
      </div>
    </header>

    <main>
      <h1>Post a New Update</h1>
      <form action="add_post.php" method="POST">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <button type="submit">Post</button>
      </form>

      <hr>

      <h2>Existing Posts</h2>
      <?php
      include 'config.php';
      $sql = "SELECT id, title, description, date_posted FROM updates ORDER BY date_posted DESC";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $datetime = new DateTime($row['date_posted']);
            $datetime->setTimezone($target_timezone);
            $local_time_formatted = $datetime->format('F j, Y g:i A');

            echo "
            <div>
              
              <form action='update_post.php' method='POST' class='update-form' id='update-form-{$row['id']}'>
                <input type='hidden' name='id' value='{$row['id']}'>
                <input type='text' name='title' value='".htmlspecialchars($row['title'], ENT_QUOTES)."' required>
                <textarea name='description' required>".htmlspecialchars($row['description'], ENT_QUOTES)."</textarea>
              </form>
                
              <div class='post-actions'>
                  <button type='submit' class='update-btn' form='update-form-{$row['id']}'>Update</button>
                  
                  <form action='delete_post.php' method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this post?\");'>
                      <input type='hidden' name='id' value='{$row['id']}'>
                      <button type='submit' class='delete-btn'>Delete</button>
                  </form>
              </div>

              <span class='post-date'>Posted on: " . $local_time_formatted . "</span>
            </div>
            ";
        }
      } else {
        echo "<p>No posts yet.</p>";
      }
      $conn->close();
      ?>
    </main>
  </div>
</body>
</html>