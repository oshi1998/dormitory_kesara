<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');

    $check_in = date("Y-m-d H:i:s");

    $sql = "UPDATE daily_books SET status='อยู่ระหว่างการเช็คอิน',check_in_datetime=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$check_in,$_GET['id']]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "เช็คอิน $_GET[id] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "เช็คอินไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
}
