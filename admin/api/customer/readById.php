<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');


    $sql = "SELECT * FROM customers WHERE id_card = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$_POST['id_card']]);

    if ($result) {
        $row = $stmt->fetchObject();
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "โหลดข้อมูลลูกค้า $_POST[id_card] สำเร็จ", 'data' => $row]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'โหลดข้อมูลลูกค้าไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
