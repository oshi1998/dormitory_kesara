<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');


    if (empty($_POST['id_card'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลเลขบัตรประชาชน']);
        exit();
    } else if (empty($_POST['password'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกรหัสผ่าน']);
        exit();
    }

    $sql = "SELECT * FROM customers WHERE id_card = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['id_card']]);
    $row = $stmt->fetchObject();

    if (!empty($row)) {
        if (password_verify($_POST['password'], $row->password)) {
            if ($row->active == "Enable") {
                
                session_start();
                $_SESSION['CUSTOMER_LOGIN'] = TRUE;
                $_SESSION['CUSTOMER_ID'] = $row->id_card;
                $_SESSION['CUSTOMER_FIRSTNAME'] = $row->firstname;
                $_SESSION['CUSTOMER_LASTNAME'] = $row->lastname;

                http_response_code(200);
                echo json_encode(['status'=>true,'message'=>'เข้าสู่ระบบสำเร็จ']);
                exit();
            } else {
                http_response_code(412);
                echo json_encode(['status' => false, 'message' => "บัญชี $_POST[id_card] ถูกปิดการใช้งานชั่วคราว กรุณาติดต่อผู้ดูแลระบบ"]);
                exit();
            }
        } else {
            http_response_code(401);
            echo json_encode(['status' => false, 'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง']);
            exit();
        }
    } else {
        http_response_code(401);
        echo json_encode(['status' => false, 'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง']);
        exit();
    }
} else {
    http_response_code(405);
}
