<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    $sql = "SELECT rooms.id FROM rooms,roomtypes
    WHERE rooms.type=roomtypes.id
    AND rooms.type = :type
    AND rooms.active = :active
    AND rooms.id NOT IN
    (SELECT daily_books.room_id FROM daily_books WHERE :checkin_date < check_out AND :checkout_date > check_in AND status != :status)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'type' => $_POST['id'],
        'active' => "พร้อมใช้งาน",
        'checkin_date' => $_POST['checkin'],
        'checkout_date' => $_POST['checkout'],
        'status' => 'ยกเลิก'
    ]);

    $rooms = $stmt->fetchAll();

    if(!empty($rooms)){
        http_response_code(200);
        echo json_encode(['status'=>true,'message'=>"มีห้องพร้อมบริการ",'data'=>$rooms]);
    }else{
        http_response_code(412);
        echo json_encode(['status'=>false,'message'=>"ไม่มีห้องรายวัน พร้อมบริการในช่วงเวลา $_POST[checkin] ถึง $_POST[checkout] กรุณาเปลี่ยนวันใหม่"]);
    }
    
} else {
    http_response_code(405);
}
