<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-Type:application/json");
    require_once('../connect.php');


    $sql = "UPDATE customers SET active = :active WHERE id_card = :id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'active' => "Disable",
        'id' => $_GET['id_card']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "ปิดใช้งานบัญชี $_GET[id_card] สำเร็จ"]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'ปิดใช้งานไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
