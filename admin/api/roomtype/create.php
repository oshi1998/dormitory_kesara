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
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลชื่อประเภท']);
        exit;
    } else if (empty($_POST['type'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณาเลือกรูปแบบ']);
        exit;
    } else if (empty($_POST['description'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลคำอธิบาย']);
        exit;
    } else if (empty($_POST['price'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลราคา']);
        exit;
    }


    $extention = strrchr($_FILES['img']['name'], '.');
    $file = uniqid() . $extention;
    $dir_target = "../../dist/img/room/" . $file;

    $sql = "INSERT INTO roomtypes (name,type,description,price,img) VALUES (:name,:type,:description,:price,:img)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'img' => $file
    ]);

    if ($result) {

        move_uploaded_file($_FILES['img']['tmp_name'], $dir_target);

        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "เพิ่มข้อมูลประเภทห้องพักสำเร็จ"]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'เพิ่มข้อมูลประเภทห้องพักไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
