<?php

if($_SERVER['REQUEST_METHOD']=="GET"){
    header("Content-Type:application/json");
    require_once('../connect.php');

    $sql = "SELECT monthly_rooms.id,floor,price,img,img_position,monthly_rooms.type,description FROM monthly_rooms,roomtypes WHERE monthly_rooms.type=roomtypes.id AND monthly_rooms.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $row1 = $stmt->fetchObject();

    $sql = "SELECT img FROM images WHERE type_id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$row1->type]);
    $row2 = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode(['status'=>true,'message'=>"โหลดข้อมูลห้อง $_GET[id] สำเร็จ",'room'=>$row1,'images'=>$row2]);
}else{
    http_response_code(405);
}