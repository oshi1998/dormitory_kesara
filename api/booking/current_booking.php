<?php

if($_SERVER['REQUEST_METHOD']=="GET"){

    header("Content-Type:application/json");
    require_once('../connect.php');

    $sql = "SELECT current_book FROM customers WHERE id_card = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id_card']]);
    $row = $stmt->fetchObject();

    if(!empty($row->current_book)){
        $sql = "SELECT * FROM daily_books WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$row->current_book]);
        $row = $stmt->fetchObject();

        http_response_code(200);
        echo json_encode(['status'=>true,'message'=>"โหลดข้อมูลการจองปัจจุบันสำเร็จ",'data'=>$row]);
    }else{
        http_response_code(412);
        echo json_encode(['status'=>false,'message'=>"ท่านไม่ได้อยู่ระหว่างการใช้งานห้องพักใดๆ ในขณะนี้"]);
    }
}else{
    http_response_code(405);
}