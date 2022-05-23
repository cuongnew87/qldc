<?php
include('../config.php');
include(ROOT_PATH . "library/encryption.php");
$converter = new Encryption;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Sample array
    $qrData = $_POST['qrCitizenData'];

    /*0 - new cid, 1 - old cid, 2 - name, 
    3 - dob (ddMMyyyy), 4 - gender, 5 - address, 
    6 - cid provided date
    */
    $decoded_datas = explode("|", $qrData);
    // $email = $_POST['email'];

    $message = '';
    $signal = 0;
    
    // lấy thông tin qrData
    // kiểm tra thông tin có trong db chưa

    $sql = "Select count(*) AS num_resident from residents where rsd_identity = '" . $decoded_datas[0] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $num_resident = $row['num_resident'];
        }
        if($num_resident == 0){
            $sql = "INSERT INTO residents(rsd_name, rsd_identity, rsd_sex, rsd_dob, rsd_image) VALUES ('$decoded_datas[2]', '$decoded_datas[0]', '$decoded_datas[4]', '$decoded_datas[3]', 'user-default.png')";
            $result = $conn->query($sql);

            $message = 'Đăng ký người dùng thành công';
        }
        else{
            $message = 'Người dùng tồn tại';
        }
    }

    header("Content-Type: application/json");

    if ($signal === 2) {
        http_response_code(200);
        $status = 200;
        $message = "Thành công!";
    } else if ($signal === 1) {
        http_response_code(409);
        $status = 409;
        $message = "Người dùng đã tồn tại!";
    }

    // echo json_encode([
    //     "status" => $status,
    //     'message' => $message

    // ]);
    echo json_encode([
        "status" => 200,
        "message" => $message
    ]);
} else {
    http_response_code(405);
    echo json_encode([
        'status' => 405,
        'message' => 'Wrong method!'

    ]);
}

exit();