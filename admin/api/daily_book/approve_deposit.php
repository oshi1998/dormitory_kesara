<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "UPDATE daily_books SET status='รอเช็คอิน' WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$_GET['id']]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "อนุมัติชำระค่ามัดจำสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "อนุมัติไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
}
