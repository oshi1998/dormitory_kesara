<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    if (empty($_FILES['img']['name'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณาอัพโหลดรูปภาพ']);
        exit;
    } else if (empty($_POST['name'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลชื่อธนาคาร']);
        exit;
    } else if (empty($_POST['account_number'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกเลขบัญชี']);
        exit;
    } else if (empty($_POST['branch'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลสาขา']);
        exit;
    } else if (empty($_POST['holder'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลเจ้าของบัญชี']);
        exit;
    }


    $extention = strrchr($_FILES['img']['name'], '.');
    $file = uniqid() . $extention;
    $dir_target = "../../dist/img/bank/" . $file;

    $sql = "INSERT INTO banks (name,account_number,branch,holder,img) VALUES (:name,:acc,:branch,:holder,:img)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'name' => $_POST['name'],
        'acc' => $_POST['account_number'],
        'branch' => $_POST['branch'],
        'holder' => $_POST['holder'],
        'img' => $file
    ]);

    if ($result) {

        move_uploaded_file($_FILES['img']['tmp_name'], $dir_target);

        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "เพิ่มข้อมูลบัญชีธนาคารสำเร็จ"]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'เพิ่มข้อมูลบัญชีธนาคารไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
