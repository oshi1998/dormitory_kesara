<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    header("Content-Type:application/json");
    require_once('../connect.php');

    $sql = "SELECT name FROM roomtypes WHERE name = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['name']]);
    $row = $stmt->fetchAll();

    if (empty($row)) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "ชื่อประเภท $_POST[name] สามารถใช้งานได้"]);
    } else {
        http_response_code(200);
        echo json_encode(['status' => false, 'message' => "ชื่อประเภท $_POST[name] มีอยู่แล้วในระบบ"]);
    }
} else {
    http_response_code(405);
}
