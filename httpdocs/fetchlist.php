<?php
include 'config.php';

$target_timezone = new DateTimeZone('Asia/Manila');

$sql = "SELECT * FROM sphinx0945_studentlist.list ORDER BY workflow_status DESC, last_name ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        
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
                        <p><strong>Gender:\t\t</strong> " . htmlspecialchars($row['gender']) . "</p>
                        <p><strong>Address:\t\t</strong> " . htmlspecialchars($row['address']) . "</p>
                        <p><strong>Email:\t\t</strong> " . htmlspecialchars($row['email']) . "</p>
                        <p><strong>Contact:\t\t</strong> " . htmlspecialchars($row['contactno']) . "</p>
                        <p><strong>Program:\t\t</strong> " . htmlspecialchars($row['program']) . "</p>
                        <p><strong>Year:\t\t</strong> " . htmlspecialchars($row['year']) . "</p>
                        <p><strong>Semester:\t\t</strong> " . htmlspecialchars($row['semester']) . "</p>
                    </div>
                </td>
            </tr>
        ";
    }
}
?>
