<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    if (isset($_POST['examine']) && !empty($_POST['examine'])) {
        if ($_POST['examine'] == 'id_card') {
            $sql = "SELECT id_card FROM customers WHERE id_card=?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$_POST['id_card']]);

            if ($result) {
                $row = $stmt->fetchObject();
                if (empty($row)) {
                    http_response_code(200);
                    echo json_encode(['status' => true, 'examine' => 'Empty']);
                } else {
                    http_response_code(200);
                    echo json_encode(['status' => true, 'examine' => 'Not Empty', 'message' => "เลขบัตรประจำตัวประชาชน $_POST[id_card] ถูกใช้งานแล้ว"]);
                }
            } else {
                http_response_code(412);
            }
        } else if ($_POST['examine'] == 'email') {
            $sql = "SELECT email FROM customers WHERE email=?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$_POST['email']]);

            if ($result) {
                $row = $stmt->fetchObject();
                if (empty($row)) {
                    http_response_code(200);
                    echo json_encode(['status' => true, 'examine' => 'Empty']);
                } else {
                    http_response_code(200);
                    echo json_encode(['status' => true, 'examine' => 'Not Empty', 'message' => "อีเมล $_POST[email] ถูกใช้งานแล้ว"]);
                }
            } else {
                http_response_code(412);
            }
        }
    } else {
        http_response_code(412);
    }
} else {
    http_response_code(405);
}
