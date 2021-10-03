<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    session_start();

    $sql = "INSERT INTO daily_books (id,customer_username,daterange,duration,check_in,check_out,cost,daily_room_id,status)
    VALUES (:id,:customer,:daterange,:duration,:checkin,:checkout,:cost,:room,:status)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'id' => $_SESSION['MYBOOK']['ID'],
        'customer' => $_SESSION['CUSTOMER_USERNAME'],
        'daterange' => $_SESSION['MYBOOK']['DATERANGE'],
        'duration' => $_SESSION['MYBOOK']['DURATION'],
        'checkin' => $_SESSION['MYBOOK']['CHECK_IN'],
        'checkout' => $_SESSION['MYBOOK']['CHECK_OUT'],
        'cost' => $_SESSION['MYBOOK']['COST'],
        'room' => $_SESSION['MYBOOK']['ROOM_ID'],
        'status' => "รออนุมัติ"
    ]);

    if($result){

        $sql = "UPDATE customers SET current_book=:cb WHERE username = :usr";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'cb' => $_SESSION['MYBOOK']['ID'],
            'usr' => $_SESSION['CUSTOMER_USERNAME']
        ]);

        unset($_SESSION['MYBOOK']);

        http_response_code(200);
        echo json_encode(['status'=>true,'message'=>"ส่งแบบฟอร์มขอจองห้องรายวันสำเร็จ"]);
    }else{
        http_response_code(412);
        echo json_encode(['status'=>false,'message'=>"ส่งแบบฟอร์มขอจองห้องรายวันไม่สำเร็จ"]);
    }
    
} else {
    http_response_code(405);
}
