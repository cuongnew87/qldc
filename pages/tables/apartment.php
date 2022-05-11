<?php

include(dirname(__DIR__, 2) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$apartmentId = $_POST['apartmentId'];
$buildingId = $_POST['buildingId'];
$apartmentName = $_POST['apartmentName'];
$apartmentSize = $_POST['apartmentSize'];
$apartmentType = $_POST['apartmentType'];

if($apartmentId == 0){
    $sql = "INSERT INTO apartments(bldid, a_name, a_size, atype_id) VALUES ('$buildingId', '$apartmentName', '$apartmentSize', '$apartmentType')";
} else{
    $sql = "UPDATE apartments SET bldid = '$buildingId', a_name = '$apartmentName', a_size = '$apartmentSize', atype_id = '$apartmentType' WHERE aid = '$apartmentId'";
}

$result = $conn->query($sql);

if ($result){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
$conn->close();
?>