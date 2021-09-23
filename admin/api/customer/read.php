<?php

if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-Type:application/json");
    require_once('../connect.php');

    if(isset($_POST['getDataByIdCard'])){
        $sql = "SELECT * FROM customers WHERE id_card = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['id_card']]);
        $row = $stmt->fetchObject();

        if(!empty($row)){
            http_response_code(200);
            echo json_encode(['status'=>true,'message'=>"โหลดข้อมูลผู้ใช้งาน $_POST[id_card] สำเร็จ",'data'=>$row]);
            exit();
        }else{
            http_response_code(401);
            echo json_encode(['status'=>false,'message'=>"ไม่มีข้อมูลผู้ใช้งาน $_POST[id_card]"]);
            exit();
        }
    }else{
        http_response_code(412);
        exit();
    }
}else{
    http_response_code(405);
}