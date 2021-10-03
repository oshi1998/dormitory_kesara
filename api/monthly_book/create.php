<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    session_start();

    $sql = "INSERT INTO monthly_books (id,customer_username,schedule_move_in,monthly_room_id,cost,status) VALUES
    (:id,:customer,:schedule,:room,:cost,:status)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'id' => $_SESSION['MYBOOK_MONTH']['ID'],
        'customer' => $_SESSION['CUSTOMER_USERNAME'],
        'schedule' => $_SESSION['MYBOOK_MONTH']['SCHEDULE_MOVE_IN'],
        'cost' => $_SESSION['MYBOOK_MONTH']['COST'],
        'room' => $_SESSION['MYBOOK_MONTH']['ROOM_ID'],
        'status' => "รออนุมัติ"
    ]);

    if ($result) {

        $sql = "UPDATE customers SET current_book=:cb WHERE username = :usr";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'cb' => $_SESSION['MYBOOK_MONTH']['ID'],
            'usr' => $_SESSION['CUSTOMER_USERNAME']
        ]);

        unset($_SESSION['MYBOOK_MONTH']);

        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "ส่งแบบฟอร์มขอจองห้องรายเดือนสำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "ส่งแบบฟอร์มขอจองห้องรายเดือนไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
}
