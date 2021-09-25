<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "UPDATE repairs SET status='รับเรื่องแล้ว' WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$_GET['id']]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "รับเรื่องสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "รับเรื่องไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
}
