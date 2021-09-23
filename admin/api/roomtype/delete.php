<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    if (empty($_GET['id'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "ไม่มีข้อมูล ID"]);
        exit;
    } else {

        $sql = "SELECT id FROM rooms WHERE type=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetchAll();

        if (empty($row)) {

            $sql = "SELECT img FROM roomtypes WHERE id =?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_GET['id']]);
            $row = $stmt->fetchObject();
            $img = $row->img;

            $delete_target = "../../dist/img/room/".$img;

            $sql = "DELETE FROM roomtypes WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$_GET['id']]);

            if ($result) {

                unlink($delete_target);

                http_response_code(200);
                echo json_encode(['status' => true, 'message' => "ลบข้อมูลประเภทห้อง $_GET[id] สำเร็จ"]);
                exit;
            } else {
                http_response_code(412);
                echo json_encode(['status' => false, 'message' => "ลบข้อมูลประเภทห้อง $_GET[id] ไม่สำเร็จ"]);
                exit;
            }
        } else {
            http_response_code(412);
            echo json_encode(['status' => false, 'message' => "ไม่สามารถลบได้ เนื่องจากมีข้อมูลห้องอยู่"]);
            exit;
        }
    }
} else {
    http_response_code(405);
}
