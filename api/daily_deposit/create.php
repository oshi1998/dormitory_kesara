<?php

if($_SERVER['REQUEST_METHOD']=="POST"){

    header("Content-type:application/json");
    require_once('../connect.php');
    session_start();

    $id = "DP".date("Ymd")."-".rand(10,999);

    $extension = strrchr($_FILES['slip']['name'],'.');
    $file = $id.$extension;
    $dir_target = "../../admin/dist/img/slip/".$file;

    $sql = "INSERT INTO deposits (id,customer_username,book_id,amount,slip,receive_bank,receive_account_number,
    receive_owner,transfer_bank,transfer_account_number,transfer_owner,transfer_datetime) VALUES 
    (:id,:cus,:book,:amount,:slip,:rb,:racc,:ro,:tb,:tacc,:to,:tdate)";

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'id' => $id,
        'cus' => $_SESSION['CUSTOMER_USERNAME'],
        'book' => $_POST['book_id'],
        'amount' => $_POST['amount'],
        'slip' => $file,
        'rb' => $_POST['receive_bank'],
        'racc' => $_POST['receive_account_number'],
        'ro' => $_POST['receive_owner'],
        'tb' => $_POST['transfer_bank'],
        'tacc' => $_POST['transfer_account_number'],
        'to' => $_POST['transfer_owner'],
        'tdate' => $_POST['transfer_datetime']
    ]);
    
    if($result){
        move_uploaded_file($_FILES['slip']['tmp_name'],$dir_target);

        $sql = "UPDATE daily_books SET status=:status WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'status' => "รอตรวจสอบ",
            'id' => $_POST['book_id']
        ]);

        http_response_code(200);
        echo json_encode(['status'=>true,'message'=>'ชำระค่ามัดจำสำเร็จ']);
    }else{
        http_response_code(412);
        echo json_encode(['status'=>false,'message'=>'ชำระค่ามัดจำไม่สำเร็จ']);
    }
}else{
    http_response_code(405);
}