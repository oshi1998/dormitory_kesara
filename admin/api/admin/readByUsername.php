<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');


    $sql = "SELECT * FROM admins WHERE username = ? ORDER BY created DESC";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$_POST['username']]);

    if ($result) {
        $row = $stmt->fetchObject();
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "โหลดข้อมูลผู้ดูแลระบบ $_POST[username] สำเร็จ", 'data' => $row]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'โหลดข้อมูลผู้ดูแลระบบไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
