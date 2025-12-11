<?php
$conn = new mysqli("johnny.heliohost.org", "sphinx0945_dev", "Dev12311", "sphinx0945_studentlist");
if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$sql = "SELECT program, COUNT(*) AS total 
        FROM registered
        GROUP BY program";

$result = $conn->query($sql);

$response = [
    "BSIT" => 0,
    "BIT-CT" => 0,
    "BSIE" => 0,
    "BTLED-ICT" => 0,
	"DMT" => 0
];

while ($row = $result->fetch_assoc()) {
    if ($row['program'] === "BSIT") {
        $response["BSIT"] = $row["total"];
    }
    if ($row['program'] === "BIT-CT") {
        $response["BIT-CT"] = $row["total"];
    }
    if ($row['program'] === "BSIE") {
        $response["BSIE"] = $row["total"];
    }
    if ($row['program'] === "BTLED-ICT") {
        $response["BTLED-ICT"] = $row["total"];
    }
	if ($row['program'] === "DMT") {
        $response["DMT"] = $row["total"];
    }
}

echo json_encode($response);
?>
