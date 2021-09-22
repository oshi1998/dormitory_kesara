<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    if (empty($_POST['firstname'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลชื่อจริง ให้ถูกต้อง']);
        exit();
    } else if (empty($_POST['lastname'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลนามสกุล ให้ถูกต้อง']);
        exit();
    } else if (empty($_POST['gender'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณาเลือกเพศ ให้ถูกต้อง']);
        exit();
    } else if (empty($_POST['phone_number'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลเบอร์โทร ให้ถูกต้อง']);
        exit();
    } else if (empty($_POST['email'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลอีเมล ให้ถูกต้อง']);
        exit();
    }

    session_start();

    $sql = "UPDATE customers SET firstname=:firstname,lastname=:lastname,gender=:gender,phone_number=:phone,email=:email WHERE id_card = :id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'gender' => $_POST['gender'],
        'phone' => $_POST['phone_number'],
        'email' => $_POST['email'],
        'id' => $_SESSION['CUSTOMER_ID']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => 'อัพเดตข้อมูลสำเร็จ', 'id' => $_SESSION['CUSTOMER_ID']]);
        exit();
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'อัพเดตข้อมูลไม่สำเร็จ เนื่องจากข้อมูลไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง']);
        exit();
    }
} else {
    http_response_code(405);
}
