<?php

if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "SELECT monthly_books.id,username,schedule_move_in,cost,firstname,lastname,address,phone_number,email,monthly_books.status,monthly_room_id FROM monthly_books,customers WHERE monthly_books.customer_username=customers.username AND monthly_books.status = 'รออนุมัติ'";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode(['status'=>true,'message'=>"โหลดข้อมูลรายการจองห้องพักรายเดือน สถานะรออนุมัติ สำเร็จ",'data'=>$row]);
}else{
    http_response_code(405);
}