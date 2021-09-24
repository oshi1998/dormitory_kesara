<?php


if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-type:application/json");

    session_start();

    $duration = intval($_SESSION['MYBOOK']['DURATION']);
    $price = floatval($_POST['price']);
    $cost = $price*$duration;

    $_SESSION['MYBOOK']['ROOM_ID'] = $_POST['id'];
    $_SESSION['MYBOOK']['COST'] = $cost;

    http_response_code(200);
    echo json_encode(['status'=>200,'message'=>"เพิ่มข้อมูลห้อง $_POST[id] ลง SESSION สมุดจองห้องพักรายวันสำเร็จ"]);

}else{

}