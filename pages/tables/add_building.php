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

// $sql1 = "DROP PROCEDURE LoopDemo; "
// ."DELIMITER $$ "
// ."CREATE PROCEDURE LoopDemo() "
// ."BEGIN "
// ."DECLARE building_id  INT; "
// ."DECLARE num_service  INT; "
// ."DECLARE x  INT; "    
// ."SET x = 1; "
// ."SET building_id = " . '(SELECT `buildings`.`bldid` FROM `buildings` ORDER BY `buildings`.`bldid` DESC LIMIT 1); '
// ."SET num_service =  (SELECT COUNT(*) FROM `utilities`); "
// ."loop_label:  LOOP "
// ."IF  x > num_service THEN "
// ."LEAVE  loop_label; "
// ."END  IF; "
// .'INSERT INTO `utilities_building`(bldid, utltid) VALUES(building_id, x);'
// ."SET  x = x + 1; "
// ."END LOOP; "
// ."END$$ "
// ."DELIMITER; "
// ."CALL LoopDemo(); ";

$sql1 = "CALL LoopDemo();";

$result1 = $conn->query($sql1);

if ($result1){
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201, "result1" => $result1));
}
$conn->close();
?>