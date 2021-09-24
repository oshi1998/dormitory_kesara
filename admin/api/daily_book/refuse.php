<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "UPDATE daily_books SET status=:status,note=:note WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'status' => "ยกเลิก",
        'note' => $_POST['note'],
        'id' => $_POST['id']
    ]);

    if ($result) {
        
        $sql = "UPDATE customers SET current_book='' WHERE current_book = '$_POST[id]'";
        $pdo->query($sql);

        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "ยกเลิกหมายเลขจอง $_POST[id] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "ยกเลิกไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
}
