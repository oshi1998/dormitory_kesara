<?php

if($_SERVER['REQUEST_METHOD']=="GET"){
    header("Content-type:application/json");
    require_once('../connect.php');

    $sql = "SELECT (SELECT count(*) FROM admins) as c1,
    (SELECT count(*) FROM customers) as c2,
    (SELECT count(*) FROM daily_rooms) as c3,
    (SELECT count(*) FROM monthly_rooms) as c4";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetchObject();

    http_response_code(200);
    echo json_encode(['status'=>true,'message'=>'นับจำนวนสำเร็จ','data'=>$row]);
}else{
    http_response_code(405);
}