<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    session_start();

    if (empty($_POST['topic'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกหัวข้อเรื่องที่แจ้ง']);
        exit;
    } else if (empty($_POST['description'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกรายละเอียด']);
        exit;
    }

    $id = "RP" . date("Ymd") . "-" . rand(10, 999);

    if (!empty($_FILES['img']['name'])) {
        $extention = strrchr($_FILES['img']['name'], '.');
        $file = $id . $extention;
        $dir_target = "../../admin/dist/img/repair/" . $file;
    } else {
        $file = "";
    }

    $sql = "INSERT INTO repairs (id,topic,description,room_id,customer_username,img,status) VALUES
    (:id,:topic,:desc,:room,:cus,:img,:status)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'id' => $id,
        'topic' => $_POST['topic'],
        'desc' => $_POST['description'],
        'room' => $_POST['room_id'],
        'cus' => $_SESSION['CUSTOMER_USERNAME'],
        'img' => $file,
        'status' => "รอผู้ดูแลรับเรื่อง"
    ]);

    if ($result) {
        if ($file != "") {
            move_uploaded_file($_FILES['img']['tmp_name'], $dir_target);
        }
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => 'แจ้งซ่อมสำเร็จ']);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'แจ้งซ่อมไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
