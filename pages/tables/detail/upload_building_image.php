<?php
$filename = $_FILES['image']["name"];
$bannerpath = "../../../dist/img/buildings/" .$filename;
    header('Access-Control-Allow-Origin: *');
    if(move_uploaded_file($_FILES["image"]["tmp_name"], $bannerpath)) {
        echo "success";
    } else{
        echo "fail";;
    }
?>
