<?php
include(dirname(__DIR__, 2) . "\config.php");

// Start the session
session_start();

// Create connection
$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `user` WHERE `user`.`user_mail` = '" . $_POST["email"] . "'AND `user`.`user_pass` ='" . $_POST["password"] . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $_SESSION["username"] = $row['user_name'];
        header("Location: ../../index.php");
    }
} else{
    header("Location: login.html?login=0");
}
$conn->close();

?>