<?php

if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "SELECT daily_books.id,username,daterange,duration,time,cost,firstname,lastname,address,phone_number,email,daily_books.status,daily_room_id,check_in_datetime FROM daily_books,customers WHERE daily_books.customer_username=customers.username AND daily_books.status = 'อยู่ระหว่างการเช็คอิน'";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode(['status'=>true,'message'=>"โหลดข้อมูลรายการจองห้องพักรายวัน สถานะอยู่ระหว่างการเช็คอินสำเร็จ",'data'=>$row]);
}else{
    http_response_code(405);
}