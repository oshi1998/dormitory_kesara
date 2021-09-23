<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    if (empty($_GET['id'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "ไม่มีข้อมูล ID"]);
        exit;
    } else {

        $sql = "SELECT id FROM books WHERE room_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetchAll();

        if (empty($row)) {

            $sql = "DELETE FROM rooms WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$_GET['id']]);

            if ($result) {
                http_response_code(200);
                echo json_encode(['status' => true, 'message' => "ลบข้อมูลห้อง $_GET[id] สำเร็จ"]);
                exit;
            } else {
                http_response_code(412);
                echo json_encode(['status' => false, 'message' => "ลบข้อมูลห้อง $_GET[id] ไม่สำเร็จ"]);
                exit;
            }
        } else {
            http_response_code(412);
            echo json_encode(['status' => false, 'message' => "ไม่สามารถลบได้ เนื่องจากข้อมูลห้องพัก $_GET[id] ถูกใช้งาน"]);
            exit;
        }
    }
} else {
    http_response_code(405);
}
