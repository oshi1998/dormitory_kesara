<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');


    $sql = "SELECT * FROM banks ORDER BY created DESC";
    $result = $pdo->query($sql);

    if ($result) {
        $row = $result->fetchAll();
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
