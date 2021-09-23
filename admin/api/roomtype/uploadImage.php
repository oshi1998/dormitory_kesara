<?php

session_start();

if ($_FILES['file']['tmp_name'] && isset($_SESSION['type_id'])) {

    require_once('../connect.php');

    $extention = strrchr($_FILES['file']['name'],'.');
    $file = uniqid().$extention;
    $dir_target = "../../dist/img/room/".$file;

    $sql = "INSERT INTO images (img,type_id) VALUES (:img,:id)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'img' => $file,
        'id' => $_SESSION['type_id']
    ]);

    if($result){
        move_uploaded_file($_FILES['file']['tmp_name'],$dir_target);
        http_response_code(200);
        echo json_encode(['status'=>true,'message'=>"อัพโหลดภาพ $file สำเร็จ"]);
    }else{
        http_response_code(412);
        echo json_encode(['status'=>false,'message'=>"อัพโหลดภาพไม่สำเร็จ"]);
    }
    
}
