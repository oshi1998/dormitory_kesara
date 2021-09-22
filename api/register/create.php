<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');


    if (empty($_POST['id_card'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลเลขบัตรประชาชน ให้ถูกต้อง']);
        exit();
    } else if (empty($_POST['firstname'])) {
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
    } else if (empty($_POST['password'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกรหัสผ่าน ให้ถูกต้อง']);
        exit();
    }

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO customers (id_card,firstname,lastname,gender,phone_number,address,email,password,status)
        VALUES (:id,:firstname,:lastname,:gender,:phone,:address,:email,:password,:status)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'id' => $_POST['id_card'],
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'gender' => $_POST['gender'],
        'phone' => $_POST['phone_number'],
        'address' => $_POST['address'],
        'email' => $_POST['email'],
        'password' => $password,
        'status' => "ว่าง"
    ]);

    if ($result) {

        session_start();
        $_SESSION['CUSTOMER_LOGIN'] = TRUE;
        $_SESSION['CUSTOMER_ID'] = $_POST['id_card'];
        $_SESSION['CUSTOMER_FIRSTNAME'] = $_POST['firstname'];
        $_SESSION['CUSTOMER_LASTNAME'] = $_POST['lastname'];

        http_response_code(200);
        echo json_encode(['status' => true, 'message' => 'ลงทะเบียนสำเร็จ']);
        exit();
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'ลงทะเบียนไม่สำเร็จ เนื่องจากข้อมูลไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง']);
        exit();
    }
} else {
    http_response_code(405);
}
