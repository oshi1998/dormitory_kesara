<?php

if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "SELECT monthly_books.id,id_card,schedule_move_in,cost,firstname,lastname,address,phone_number,email,monthly_books.status,monthly_room_id,note FROM monthly_books,customers WHERE monthly_books.customer_id=customers.id_card AND monthly_books.status = 'ยกเลิก'";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode(['status'=>true,'message'=>"โหลดข้อมูลรายการจองห้องพักรายเดือน สถานะยกเลิกสำเร็จ",'data'=>$row]);
}else{
    http_response_code(405);
}