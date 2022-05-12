<?php

include(dirname(__DIR__, 3) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$memberId = $_POST['memberId'];
$memberRelationship = $_POST['memberRelationship'];
$buildingId = $_POST['buildingId'];
$apartmentId = $_POST['apartmentId'];

$sql = "UPDATE residents SET bldid = '$buildingId', aid = '$apartmentId', rsd_relationship = '$memberRelationship' where rsdid = '$memberId'";

$result = $conn->query($sql);

if ($result){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
$conn->close();
?>