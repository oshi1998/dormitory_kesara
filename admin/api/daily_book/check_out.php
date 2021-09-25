<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-type:application/json");
    require_once('../connect.php');

    $check_out = date("Y-m-d H:i:s");

    $sql = "UPDATE daily_books SET status='เสร็จสิ้น',check_out_datetime=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$check_out,$_GET['id']]);

    if ($result) {

        $sql = "UPDATE customers SET current_book='' WHERE current_book = '$_GET[id]'";
        $pdo->query($sql);

        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "เช็คเอาท์ $_GET[id] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "เช็คเอาท์ไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
}
