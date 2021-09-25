<?php

if($_SERVER['REQUEST_METHOD']=="GET"){

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "SELECT (SELECT count(*) FROM monthly_books WHERE status='รออนุมัติ') as cs1,
    (SELECT count(*) FROM monthly_books WHERE status='รอชำระค่ามัดจำ') as cs2,
    (SELECT count(*) FROM monthly_books WHERE status='รอตรวจสอบ') as cs3,
    (SELECT count(*) FROM monthly_books WHERE status='รอย้ายเข้า') as cs4,
    (SELECT count(*) FROM monthly_books WHERE status='อยู่ระหว่างการเช่าห้อง') as cs5,
    (SELECT count(*) FROM monthly_books WHERE status='เสร็จสิ้น') as cs6,
    (SELECT count(*) FROM monthly_books WHERE status='ยกเลิก') as cs7";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetchObject();

    http_response_code(200);
    echo json_encode(['status'=>true,'message'=>"โหลดแจ้งเตือนสำเร็จ",'data'=>$row]);
}else{
    http_response_code(405);
}