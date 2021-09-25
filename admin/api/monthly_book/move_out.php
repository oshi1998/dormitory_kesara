<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');

    $move_out = date("Y-m-d");

    $sql = "UPDATE monthly_books SET status='เสร็จสิ้น',move_out_date=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$move_out, $_GET['id']]);

    if ($result) {

        $sql = "UPDATE customers SET current_book='' WHERE current_book = '$_GET[id]'";
        $pdo->query($sql);

        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "ย้ายออก $_GET[id] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "ย้ายออกไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
}
