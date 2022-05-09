<?php

include(dirname(__DIR__, 2) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tennantName = $_POST['tennantName'];
$tennantEmail = $_POST['tennantEmail'];
$tennantPhone = $_POST['tennantPhone'];
$tennantGender = $_POST['tennantGender'];
$tennantPhone = $_POST['tennantPhone'];
$tennantIdentity = $_POST['tennantIdentity'];
$tennantDob = $_POST['tennantDob'];
$tennantImage = $_POST['tennantImage'];
$tennantBuilding = $_POST['tennantBuilding'];

$sql = "INSERT INTO residents(bldid, rsd_name, rsd_identity, rsd_phone, rsd_mail, rsd_sex, rsd_dob, rsd_image) VALUES ('$tennantBuilding', '$tennantName', '$tennantIdentity', '$tennantPhone', '$tennantEmail', '$tennantGender', '$tennantDob', '$tennantImage')";

$result = $conn->query($sql);

if ($result){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201, "rsd_name" => $tennantName, ));
}
$conn->close();
?>