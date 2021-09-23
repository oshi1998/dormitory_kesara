<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    if (empty($_POST['username'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "ไม่มีข้อมูล USERNAME"]);
        exit;
    } else if (empty($_POST['firstname'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "กรุณากรอกข้อมูลชื่อจริง"]);
        exit;
    } else if (empty($_POST['lastname'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "กรุณากรอกข้อมูลนามสกุล"]);
        exit;
    }

    $sql = "UPDATE admins SET firstname=:firstname,lastname=:lastname,contact=:contact WHERE username=:username";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'contact' => $_POST['contact'],
        'username' => $_POST['username']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "อัพเดตข้อมูลผู้ดูแลระบบ $_POST[username] สำเร็จ"]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "อัพเดตข้อมูลผู้ดูแลระบบ $_POST[username] ไม่สำเร็จ"]);
        exit;
    }
} else {
    http_response_code(405);
}
