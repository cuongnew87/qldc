<?php

include(dirname(__DIR__, 1) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$apartmentId = $_POST['apartmentId'];
$subject = $_POST['subject'];
$content = $_POST['content'];

$sql = "INSERT INTO complains(aid, spl_subject, cpl_complain, cpl_date) VALUES ('$apartmentId', '$subject', '$content', '" . date('Y/m/d') . "')";

$result = $conn->query($sql);

if ($result){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
$conn->close();

?>