<?php
header("Content-type: text/html; charset=utf-8");

define('_AMSCODESECURITY', '16343942');
define('CURRENCY', '$');
define('WEB_URL', 'https://site.test/QLDC_khiem/');
define('ROOT_PATH', 'D:\xampp\htdocs/QLDC_khiem/');


define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'qldc');
$conn = new mysqli(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
mysqli_set_charset($conn, 'UTF8');?>