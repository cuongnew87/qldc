<?php

include(dirname(__DIR__, 2) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$buildingName = $_POST['buildingName'];
$buildingAddress = $_POST['buildingAddress'];
$buildingOwner = $_POST['buildingOwner'];
$buildingBranch = $_POST['buildingBranch'];
$buildingImage = $_POST['buildingImage'];

$sql = "INSERT INTO buildings(bld_name, bld_address, ownid, branch_id, bld_image) VALUES ('$buildingName', '$buildingAddress', '$buildingOwner', '$buildingBranch', '$buildingImage')";

$result = $conn->query($sql);

if ($result){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201, "rsd_name" => $tennantName, ));
}
$conn->close();
?>