<?php

if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "SELECT monthly_books.id,id_card,cost,firstname,lastname,address,phone_number,email,monthly_books.status,monthly_room_id,schedule_move_in,
    deposits.id as dep_id,slip,receive_bank,receive_account_number,receive_owner,transfer_bank,transfer_account_number,transfer_owner,transfer_datetime FROM monthly_books,customers,deposits WHERE monthly_books.customer_id=customers.id_card AND monthly_books.id=deposits.book_id AND monthly_books.status = 'รอตรวจสอบ'";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode(['status'=>true,'message'=>"โหลดข้อมูลรายการจองห้องพักรายวัน สถานะรอตรวจสอบ สำเร็จ",'data'=>$row]);
}else{
    http_response_code(405);
}