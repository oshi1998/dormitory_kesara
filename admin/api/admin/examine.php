<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    header("Content-Type:application/json");
    require_once('../connect.php');

    $sql = "SELECT username FROM admins WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['username']]);
    $row = $stmt->fetchAll();

    if (empty($row)) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "ชื่อผู้ใช้งาน $_POST[username] สามารถใช้งานได้"]);
    } else {
        http_response_code(200);
        echo json_encode(['status' => false, 'message' => "ชื่อผู้ใช้งาน $_POST[username] มีอยู่แล้วในระบบ"]);
    }
} else {
    http_response_code(405);
}
