<?php

include(dirname(__DIR__, 2) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$contractName = $_POST["contractName"];
$contractType = $_POST["contractType"];
$contractDate = $_POST["contractDate"];
$apartmentId = $_POST["apartmentId"];
$residentId = $_POST["residentId"];
$contractRent = $_POST["contractRent"];
$contractBuy = $_POST["contractBuy"];
$contractFile = $_POST["contractFile"];

$sql = "INSERT INTO contracts(aid, rsdid, ctr_name, ctr_type, rent_fee, buy_fee, ctr_date, file_name) VALUES ('$apartmentId', '$residentId', '$contractName', '$contractType', '$contractRent', '$contractBuy', '$contractDate', '$contractFile')";

$result = $conn->query($sql);

$sql1 = "UPDATE residents SET rsd_relationship = 'Chủ hộ', aid = $apartmentId, bldid = (SELECT bldid FROM apartments WHERE aid = $apartmentId) WHERE rsdid = " . $residentId;

$result1 = $conn->query($sql1);

$sql2 = "UPDATE apartments SET r_status = 1 WHERE aid = " . $apartmentId;

$result2 = $conn->query($sql2);

$sql2 = "UPDATE apartments SET r_status = 1 WHERE aid = " . $apartmentId;

$result2 = $conn->query($sql2);

if ($result1){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
$conn->close();

?>