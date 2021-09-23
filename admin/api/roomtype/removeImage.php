<?php

if($_SERVER['REQUEST_METHOD']=="GET"){

    header("Content-Type:application/json");
    require_once('../connect.php');

    $delete_target = "../../dist/img/room/".$_GET['img'];

    $sql = "DELETE FROM images WHERE img = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$_GET['img']]);

    if($result){
        unlink($delete_target);
        http_response_code(200);
        echo json_encode(['status'=>true,'message'=>"ลบรูปภาพ $_GET[img] สำเร็จ"]);
    }else{
        http_response_code(412);
        echo json_encode(['status'=>false,'message'=>"ลบรูปภาพ $_GET[img] ไม่สำเร็จ"]);
    }

}else{
    http_response_code(405);
}