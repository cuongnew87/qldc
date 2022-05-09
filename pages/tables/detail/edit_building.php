<?php

include(dirname(__DIR__, 3) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$buildingId = $_POST['buildingId'];
$buildingName = $_POST['buildingName'];
$buildingAddress = $_POST['buildingAddress'];
$ownerSelect = $_POST['ownerSelect'];
$buildingImage = $_POST['buildingImage'];

$sql = "UPDATE buildings SET ownid = '$ownerSelect', bld_name = '$buildingName', bld_address = '$buildingAddress', bld_image = '$buildingImage' where bldid = '$buildingId'";

$result = $conn->query($sql);

if ($result){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
$conn->close();
?>