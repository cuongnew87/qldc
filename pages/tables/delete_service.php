<?php

include(dirname(__DIR__, 2) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$serviceId = $_POST['serviceId'];
$serviceName = $_POST['serviceName'];

if($serviceId == 0){
    $sql = "INSERT INTO utilities(utlt_name) VALUES ('$serviceName')";
} else{
    $sql = "UPDATE utilities SET utlt_name = '$serviceName' WHERE utltid = '$serviceId'";
}



$result = $conn->query($sql);

if ($result){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
$conn->close();
?>