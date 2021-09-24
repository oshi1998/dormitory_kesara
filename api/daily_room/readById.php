<?php

if($_SERVER['REQUEST_METHOD']=="GET"){
    header("Content-Type:application/json");
    require_once('../connect.php');

    $sql = "SELECT daily_rooms.id,floor,price,img,img_position,daily_rooms.type,description FROM daily_rooms,roomtypes WHERE daily_rooms.type=roomtypes.id AND daily_rooms.id = ?";
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