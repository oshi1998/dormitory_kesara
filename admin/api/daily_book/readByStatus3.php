<?php

if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "SELECT daily_books.id,username,daterange,duration,time,cost,firstname,lastname,address,phone_number,email,daily_books.status,daily_room_id,
    deposits.id as dep_id,slip,receive_bank,receive_account_number,receive_owner,transfer_bank,transfer_account_number,transfer_owner,transfer_datetime FROM daily_books,customers,deposits WHERE daily_books.customer_username=customers.username AND daily_books.id=deposits.book_id AND daily_books.status = 'รอตรวจสอบ'";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode(['status'=>true,'message'=>"โหลดข้อมูลรายการจองห้องพักรายวัน สถานะรอตรวจสอบสำเร็จ",'data'=>$row]);
}else{
    http_response_code(405);
}