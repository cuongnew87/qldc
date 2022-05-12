<?php
session_start();
include(dirname(__DIR__, 1) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$phone = $_POST['phone'];
$identity = $_POST['identity'];
$dob = $_POST['dob'];
$image = $_POST['image'];

$sql = "UPDATE residents SET rsd_name = '$name', rsd_phone = '$phone', rsd_identity = '$identity', rsd_dob = '$dob', rsd_image = '$image' where rsd_mail = '".$_SESSION['email']."'";

$result = $conn->query($sql);

if ($result){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
$conn->close();
?>