<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    header("Content-type:application/json");
    require_once("../connect.php");

    if (empty(trim($_GET["id"]))) {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มี ID ส่งมา"]);
        exit;
    } else {

        $sql = "UPDATE notice_payments SET np_status=:status WHERE np_id=:id";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'status' => "ปฏิเสธ",
            'id' => $_GET["id"]
        ]);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => "ทำรายสำเร็จ"]);
            exit;
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ทำรายการไม่สำเร็จ"]);
            exit;
        }
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
