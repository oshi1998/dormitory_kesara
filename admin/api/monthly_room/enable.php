<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-Type:application/json");
    require_once('../connect.php');


    $sql = "UPDATE monthly_rooms SET active = :active WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'active' => "พร้อมใช้งาน",
        'id' => $_GET['id']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "เปิดใช้ห้องพักเลข $_GET[id] สำเร็จ"]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'เปิดใช้งานไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
