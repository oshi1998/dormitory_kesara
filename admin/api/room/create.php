<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    if (empty($_POST['id'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลเลขห้อง']);
        exit;
    } else if (empty($_POST['type'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณาเลือกประเภทห้องพัก']);
        exit;
    } else if (empty($_POST['floor'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลชั้น']);
        exit;
    }

    $sql = "INSERT INTO rooms (id,type,floor) VALUES (:id,:type,:floor)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'id' => $_POST['id'],
        'type' => $_POST['type'],
        'floor' => $_POST['floor'],
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "เพิ่มข้อมูลห้องพักสำเร็จ"]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'เพิ่มข้อมูลห้องพักไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
