<?php

if($_SERVER['REQUEST_METHOD']=="GET"){

    header("Content-Type:application/json");
    require_once('../connect.php');

    $sql = "SELECT * FROM books WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id_card']]);
    $row = $stmt->fetchAll();

    if(!empty($row)){
        http_response_code(200);
        echo json_encode(['status'=>true,'message'=>'พบข้อมูลประวัติการใช้งาน','data'=>$row]);
    }else{
        http_response_code(200);
        echo json_encode(['status'=>true,'message'=>'ไม่พบข้อมูลประวัติการใช้งาน','data'=>$row]);
    }
}else{
    http_response_code(405);
}