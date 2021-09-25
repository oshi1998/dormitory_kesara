<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-Type:application/json");
    require_once('../connect.php');


    $sql = "SELECT * FROM banks WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$_GET['id']]);

    if ($result) {
        $row = $stmt->fetchObject();
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "โหลดข้อมูลบัญชีธนาคารสำเร็จ", 'data' => $row]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'โหลดข้อมูลบัญชีธนาคารไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
