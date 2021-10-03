<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    if (empty($_POST['old_password'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกรหัสผ่านเก่า']);
        exit();
    } else if (empty($_POST['new_password'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกรหัสผ่านใหม่']);
        exit();
    }

    if ($_POST['old_password'] == $_POST['new_password']) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'รหัสผ่านเก่า และ รหัสผ่านใหม่ เหมือนกัน']);
        exit();
    } else {
        session_start();

        $sql = "SELECT * FROM customers WHERE username=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['CUSTOMER_USERNAME']]);
        $row = $stmt->fetchObject();

        if (!empty($row)) {
            if (password_verify($_POST['old_password'], $row->password)) {

                $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                $sql = "UPDATE customers SET password=:new_password WHERE username=:usr";
                $stmt = $pdo->prepare($sql);
                $result = $stmt->execute([
                    'new_password' => $password,
                    'usr' => $_SESSION['CUSTOMER_USERNAME']
                ]);

                if ($result) {
                    http_response_code(200);
                    echo json_encode(['status' => true, 'message' => 'เปลี่ยนรหัสผ่านสำเร็จ']);
                    exit();
                } else {
                    http_response_code(412);
                    echo json_encode(['status' => false, 'message' => 'เปลี่ยนรหัสผ่านไม่สำเร็จ กรุณาลองใหม่อีกครั้ง']);
                    exit();
                }
            } else {
                http_response_code(401);
                echo json_encode(['status' => false, 'message' => 'รหัสผ่านเก่า ไม่ถูกต้อง']);
                exit();
            }
        } else {
            http_response_code(404);
            echo json_encode(['status' => false, 'message' => 'ไม่พบข้อมูลผู้ใช้งาน']);
            exit();
        }
    }
} else {
    http_response_code(405);
}
