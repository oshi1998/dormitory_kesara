<?php

if($_SERVER['REQUEST_METHOD']=="GET"){
    header("Content-Type:application/json");
    require_once('../connect.php');

    $sql = "SELECT * FROM roomtypes WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $row1 = $stmt->fetchObject();

    $sql = "SELECT img FROM images WHERE type_id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $row2 = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode(['status'=>true,'message'=>"โหลดข้อมูลห้อง $_GET[id] สำเร็จ",'room'=>$row1,'images'=>$row2]);
}else{
    http_response_code(405);
}