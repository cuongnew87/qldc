<?php

include(dirname(__DIR__, 2) . "\config.php");

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rentalApartment = $_POST['rentalApartment'];
$rentalDate = $_POST['rentalDate'];

$sql = "INSERT INTO bills(aid, total, bill_paydate) VALUES ('$rentalApartment', (SELECT SUM(`contracts`.`rent_fee` + `utilities_building`.`utlt_cost`) FROM `contracts`, `utilities_building`, `apartments` WHERE `contracts`.`aid` = `apartments`.`aid` AND `utilities_building`.`bldid` = `apartments`.`aid` AND `apartments`.`aid`= $rentalApartment AND `utilities_building`.`register` = 1), '$rentalDate')";

$result = $conn->query($sql);

if ($result){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
$conn->close();
?>