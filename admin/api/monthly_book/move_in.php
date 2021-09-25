<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');

    $move_in = date("Y-m-d");

    $sql = "UPDATE monthly_books SET status='อยู่ระหว่างการเช่าห้อง',move_in_date=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$move_in, $_GET['id']]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "ย้ายเข้า $_GET[id] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "ย้ายเข้าไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
}
