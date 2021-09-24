<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    $sql = "SELECT img FROM banks WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $row = $stmt->fetchObject();
    $img = $row->img;

    $delete_target = "../../dist/img/bank/".$img;
    unlink($delete_target);

    $sql = "DELETE FROM banks WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$_GET['id']]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "ลบข้อมูลบัญชีธนาคารสำเร็จ"]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'ลบข้อมูลบัญชีธนาคารไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
