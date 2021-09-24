<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    session_start();

    $id = "DB".uniqid();

    $sql = "INSERT INTO daily_books (id,customer_id,daterange,duration,check_in,check_out,time,cost,status)
    VALUES (:id,:customer,:daterange,:duration,:checkin,:checkout,:time,:cost,:status)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'id' => $id,
        'customer' => $_SESSION['CUSTOMER_ID'],
        'daterange' => $_POST['checkin']." ถึง ".$_POST['checkout'],
        'duration' => $_POST['duration'],
        'checkin' => $_POST['checkin'],
        'checkout' => $_POST['checkout'],
        'time' => $_POST['time'],
        'cost' => $_POST['cost'],
        'status' => "รอตรวจสอบ"
    ]);

    if($result){

        $sql = "UPDATE customers SET current_book=:cb WHERE id_card = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'cb' => $id,
            'id' => $_SESSION['CUSTOMER_ID']
        ]);

        http_response_code(200);
        echo json_encode(['status'=>true,'message'=>"ส่งแบบฟอร์มขอจองห้องรายวันสำเร็จ"]);
    }else{
        http_response_code(412);
        echo json_encode(['status'=>false,'message'=>"ส่งแบบฟอร์มขอจองห้องรายวันไม่สำเร็จ"]);
    }
    
} else {
    http_response_code(405);
}
