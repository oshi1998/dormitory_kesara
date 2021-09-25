<?php


if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-type:application/json");

    session_start();

    $_SESSION['MYBOOK_MONTH']['ID'] = "MB".date("Ymd")."-".rand(10,999);
    $_SESSION['MYBOOK_MONTH']['ROOM_TYPE'] = $_POST['type'];
    $_SESSION['MYBOOK_MONTH']['SCHEDULE_MOVE_IN'] = $_POST['move_in'];
    $_SESSION['MYBOOK_MONTH']['COST'] = 0.00;
    $_SESSION['MYBOOK_MONTH']['ROOM_ID'] = '';

    http_response_code(200);
    echo json_encode(['status'=>200,'message'=>'เพิ่มข้อมูลลง SESSION สมุดจองห้องพักรายเดือนสำเร็จ']);

}else{

}