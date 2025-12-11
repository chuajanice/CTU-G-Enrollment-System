<?php
include 'config.php';

$target_timezone = new DateTimeZone('Asia/Manila');
$search = isset($_POST['query']) ? $_POST['query'] : '';

$sql = "SELECT * FROM sphinx0945_studentlist.list 
        WHERE first_name LIKE ? 
           OR middle_name LIKE ? 
           OR last_name LIKE ? 
           OR program LIKE ? 
           OR year LIKE ? 
           OR semester LIKE ? 
           OR academicstatus LIKE ?
        ORDER BY workflow_status DESC, last_name ASC";

$stmt = $conn->prepare($sql);
$like = "%$search%";
$stmt->bind_param("sssssss", $like, $like, $like, $like, $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $server_timestamp = $row['date'];
        $datetime = new DateTime($server_timestamp, new DateTimeZone('UTC'));
        $datetime->setTimezone($target_timezone);
        $local_time = $datetime->format('F j, Y g:i a');

        echo "
            <tr>
                <td>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</td>
                <td>" . htmlspecialchars($row['program']) . "</td>
                <td>" . htmlspecialchars($row['year']) . "</td>
                <td>" . htmlspecialchars($row['semester']) . "</td>
                <td>{$local_time}</td>
                <td>" . htmlspecialchars($row['academicstatus']) . "</td>
                <td>
                    <select class='workflow-dropdown' data-id='{$row['id']}'>
                        <option value='In Progress' ". ($row['workflow_status']=='In Progress'?'selected':'') .">In Progress</option>
                        <option value='Done' "       . ($row['workflow_status']=='Done'?'selected':'') .       ">Done</option>
                    </select>
                </td>
                <td>
                    <button class='expand-details' data-id='{$row['id']}'>▼</button>
                </td>
            </tr>
            <tr id='details-{$row['id']}' class='details'>
                <td colspan='10'>
                    <div class='details-grid'>
                        <p><strong>Full Name:</strong> " . htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']) . "</p>
                        <p><strong>Gender:</strong> " . htmlspecialchars($row['gender']) . "</p>
                        <p><strong>Address:</strong> " . htmlspecialchars($row['address']) . "</p>
                        <p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>
                        <p><strong>Contact:</strong> " . htmlspecialchars($row['contactno']) . "</p>
                        <p><strong>Program:</strong> " . htmlspecialchars($row['program']) . "</p>
                        <p><strong>Year:</strong> " . htmlspecialchars($row['year']) . "</p>
                        <p><strong>Semester:</strong> " . htmlspecialchars($row['semester']) . "</p>
                    </div>
                </td>
            </tr>
        ";
    }
} else {
    echo "<tr><td colspan='8' style='text-align:center; color:gray;'>No results found</td></tr>";
}
?>