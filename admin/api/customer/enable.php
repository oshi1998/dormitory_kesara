<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-Type:application/json");
    require_once('../connect.php');


    $sql = "UPDATE customers SET active = :active WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'active' => "Enable",
        'username' => $_GET['username']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "เปิดใช้งานบัญชี $_GET[username] สำเร็จ"]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'เปิดใช้งานไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
