<?php

include(dirname(__DIR__, 3) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tennantId = $_POST['tennantId'];
$tennantName = $_POST['tennantName'];
$tennantEmail = $_POST['tennantEmail'];
$tennantIdentity = $_POST['tennantIdentity'];
$tennantPhone = $_POST['tennantPhone'];
$tennantGender = $_POST['tennantGender'];

$sql = "UPDATE residents SET rsd_name = '$tennantName', rsd_identity = '$tennantIdentity', rsd_phone = '$tennantPhone', rsd_mail = '$tennantEmail', rsd_sex = '$tennantGender' where rsdid = '$tennantId'";

$result = $conn->query($sql);

if ($result){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
$conn->close();
?>