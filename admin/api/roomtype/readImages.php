<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-Type:application/json");
    require_once('../connect.php');


    $sql = "SELECT * FROM images WHERE type_id=?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$_GET['id']]);

    if ($result) {
        $row = $stmt->fetchAll();

        session_start();
        $_SESSION['type_id'] = $_GET['id'];

        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "โหลดรูปภาพห้องพัก $_GET[id] สำเร็จ", 'data' => $row]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'โหลดข้อมูลรูปภาพห้องพักไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
