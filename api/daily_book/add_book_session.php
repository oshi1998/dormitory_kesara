<?php


if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-type:application/json");

    session_start();

    $_SESSION['MYBOOK']['ID'] = "DB".date("Ymd")."-".rand(10,999);
    $_SESSION['MYBOOK']['DATERANGE'] = $_POST['checkin']." ถึง ".$_POST['checkout'];
    $_SESSION['MYBOOK']['DURATION'] =$_POST['duration'];
    $_SESSION['MYBOOK']['CHECK_IN'] =$_POST['checkin'];
    $_SESSION['MYBOOK']['CHECK_OUT'] =$_POST['checkout'];
    $_SESSION['MYBOOK']['ROOM_TYPE'] = $_POST['type'];
    $_SESSION['MYBOOK']['COST'] = 0.00;
    $_SESSION['MYBOOK']['ROOM_ID'] = '';

    http_response_code(200);
    echo json_encode(['status'=>200,'message'=>'เพิ่มข้อมูลลง SESSION สมุดจองห้องพักรายวันสำเร็จ']);

}else{

}