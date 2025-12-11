<?php
include 'config.php';
$target_timezone = new DateTimeZone('Asia/Manila');

$sql = "SELECT * FROM updates ORDER BY date_posted DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo ""; // no extra wrapper needed; post-box is in HTML
    $first = true; // highlight the newest post

    while ($row = $result->fetch_assoc()) {
        $highlightClass = $first ? 'new-post' : 'old-post';

        $server_timestamp = $row['date_posted'];
        $datetime = new DateTime($server_timestamp);
        $datetime->setTimezone($target_timezone);
        $local_time_formatted = $datetime->format('F j, Y g:i A');

        echo "
        <div class='post {$highlightClass}'>
            " . ($first ? "<div class='new-post-badge'>LATEST POST!</div>" : "") . "
            <h3 class='post-title'>" . htmlspecialchars($row['title'], ENT_QUOTES) . "</h3>
            <p>" . nl2br(htmlspecialchars($row['description'], ENT_QUOTES)) . "</p>
            <small><span class='post-date'>Posted on: " . $local_time_formatted . "</span></small>
        </div>
        ";

        $first = false; // only the first (latest) post gets badge
    }
} else {
    echo "<p>No updates yet.</p>";
}
?>
