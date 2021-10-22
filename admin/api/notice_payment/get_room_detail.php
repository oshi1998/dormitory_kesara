<?php

if($_SERVER["REQUEST_METHOD"]=="GET"){
    header("Content-type:application/json");
    require_once("../connect.php");

    if(empty(trim($_GET["id"]))){
        http_response_code(412);
        echo json_encode(['message'=>"ไม่มี ID ส่งมา"]);
        exit;
    }else{
        $sql = "SELECT monthly_room_id,cost,customer_username,firstname,lastname FROM monthly_books,customers WHERE monthly_books.customer_username=customers.username";
        $stmt = $pdo->query($sql);
        $row = $stmt->fetchObject();

        http_response_code(200);
        echo json_encode(['message'=>"โหลดข้อมูลห้อง $_GET[id] สำเร็จ",'data'=>$row]);
    }
}else{
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}