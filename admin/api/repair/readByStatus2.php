<?php

if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "SELECT repairs.id,topic,repairs.description,room_id,customer_id,firstname,lastname,address,phone_number,email,img,repairs.status,note,repairs.created
    FROM repairs,customers WHERE repairs.customer_id=customers.id_card AND repairs.status='รับเรื่องแล้ว'";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode(['status'=>true,'message'=>"โหลดข้อมูลรายการแจ้งซ่อม สถานะรับเรื่องแล้ว สำเร็จ",'data'=>$row]);
}else{
    http_response_code(405);
}