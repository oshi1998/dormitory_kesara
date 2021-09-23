<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    header("Content-Type:application/json");
    require_once('../connect.php');

    if (empty($_POST['username'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลชื่อผู้ใช้งาน ให้ถูกต้อง']);
        exit();
    } else if (empty($_POST['firstname'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลชื่อจริง ให้ถูกต้อง']);
        exit();
    } else if (empty($_POST['lastname'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลนามสกุล ให้ถูกต้อง']);
        exit();
    } else if (empty($_POST['password'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกรหัสผ่าน ให้ถูกต้อง']);
        exit();
    }

    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    $sql = "INSERT INTO admins (username,firstname,lastname,contact,password) VALUES (:username,:firstname,:lastname,:contact,:password)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'username' => $_POST['username'],
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'contact' => $_POST['contact'],
        'password' => $password
    ]);

    if($result) {
        http_response_code(200);
        echo json_encode(['status'=>true,'message'=>"เพิ่มข้อมูลผู้ดูแลระบบ $_POST[username] สำเร็จ"]);
        exit;
    }else{
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'เพิ่มข้อมูลไม่สำเร็จ เนื่องจากข้อมูลไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง']);
        exit;
    }
} else {
    http_response_code(405);
}
