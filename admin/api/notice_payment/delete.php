<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    header("Content-type:application/json");
    require_once("../connect.php");

    if (empty(trim($_GET["id"]))) {
        http_response_code(412);
        echo json_encode(['message' => "ไม่มี ID ส่งมา"]);
        exit;
    } else {

        $sql = "DELETE FROM notice_payment_details WHERE npd_np_id=:id";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'id' => $_GET["id"]
        ]);

        if ($result) {
            $sql = "DELETE FROM notice_payments WHERE np_id=:id";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                'id' => $_GET["id"]
            ]);

            if ($result) {
                http_response_code(200);
                echo json_encode(['message' => "ลบสำเร็จ"]);
                exit;
            } else {
                http_response_code(412);
                echo json_encode(['message' => "ลบไม่สำเร็จ"]);
                exit;
            }
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ลบไม่สำเร็จ"]);
            exit;
        }
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
