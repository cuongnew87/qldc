<?php

include(dirname(__DIR__, 3) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$serviceId = $_POST['serviceId'];
$service_cost = $_POST['service_cost'];
$service_register = $_POST['service_register'];
$buildingId = $_POST['buildingId'];

$sql = "UPDATE utilities_building SET utlt_cost = '$service_cost', register = '$service_register' where bldid = '$buildingId' AND utltid = '$serviceId'";

$result = $conn->query($sql);

if ($result){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
$conn->close();
?>