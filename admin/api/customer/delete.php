<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    session_start();

    if (empty($_GET['username'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "ไม่มีข้อมูล USERNAME"]);
        exit;
    } else {
        if ($_GET['username'] == $_SESSION['ADMIN_USERNAME']) {
            http_response_code(412);
            echo json_encode(['status' => false, 'message' => "ไม่สามารถลบข้อมูลตัวคุณเองได้"]);
            exit;
        } else {
            $sql = "DELETE FROM admins WHERE username = ?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$_GET['username']]);

            if ($result) {
                http_response_code(200);
                echo json_encode(['status' => true, 'message' => "ลบข้อมูลผู้ดูแลระบบ $_GET[username] สำเร็จ"]);
                exit;
            } else {
                http_response_code(412);
                echo json_encode(['status' => false, 'message' => "ลบข้อมูลผู้ดูแลระบบ $_GET[username] ไม่สำเร็จ"]);
                exit;
            }
        }
    }
} else {
    http_response_code(405);
}
