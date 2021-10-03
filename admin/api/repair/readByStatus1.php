<?php

if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "SELECT repairs.id,topic,repairs.description,room_id,customer_username,firstname,lastname,address,phone_number,email,img,repairs.status,note,repairs.created
    FROM repairs,customers WHERE repairs.customer_username=customers.username AND repairs.status='รอผู้ดูแลรับเรื่อง'";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode(['status'=>true,'message'=>"โหลดข้อมูลรายการแจ้งซ่อม สถานะรอผู้ดูแลรับเรื่อง สำเร็จ",'data'=>$row]);
}else{
    http_response_code(405);
}