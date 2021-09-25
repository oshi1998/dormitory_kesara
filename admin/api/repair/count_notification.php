<?php

if($_SERVER['REQUEST_METHOD']=="GET"){

    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "SELECT (SELECT count(*) FROM repairs WHERE status='รอผู้ดูแลรับเรื่อง') as cs1,
    (SELECT count(*) FROM repairs WHERE status='รับเรื่องแล้ว') as cs2,
    (SELECT count(*) FROM repairs WHERE status='ปฏิเสธ') as cs3";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetchObject();

    http_response_code(200);
    echo json_encode(['status'=>true,'message'=>"โหลดแจ้งเตือนสำเร็จ",'data'=>$row]);
}else{
    http_response_code(405);
}