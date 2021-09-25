<?php


if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-type:application/json");

    session_start();

    $_SESSION['MYBOOK_MONTH']['ROOM_ID'] = $_POST['id'];
    $_SESSION['MYBOOK_MONTH']['COST'] = $_POST['price'];

    http_response_code(200);
    echo json_encode(['status'=>200,'message'=>"เพิ่มข้อมูลห้อง $_POST[id] ลง SESSION สมุดจองห้องพักรายเดือนสำเร็จ"]);

}else{

}