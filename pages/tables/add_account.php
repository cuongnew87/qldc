<?php

include(dirname(__DIR__, 2) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$residentMail = $_POST['residentMail'];
$residentName = $_POST['residentName'];
$residentPassword = $_POST['residentPassword'];
$residentId = $_POST['residentId'];

$sql = "INSERT INTO user(user_id, user_mail, user_name, user_pass, role) VALUES ('$residentId', '$residentMail', '$residentName', '$residentPassword', 1)";

$result = $conn->query($sql);

if ($result){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
$conn->close();
?>