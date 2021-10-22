<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-type:application/json");
    require_once("../connect.php");

    if (empty($_POST["pay"])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณาเลือกรูปแบบการชำระเงิน"]);
        exit;
    } else {
        if ($_POST["pay"] == "ชำระด้วยเงินสด") {
            $sql = "UPDATE notice_payments SET np_status=:status,np_pay=:pay WHERE np_id=:id";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                'status' => "รอชำระเงิน (เงินสด)",
                'pay' => $_POST["pay"],
                'id' => $_POST["id"]
            ]);

            if ($result) {
                http_response_code(200);
                echo json_encode(['message' => "ดำเนินรายการสำเร็จ"]);
                exit;
            } else {
                http_response_code(412);
                echo json_encode(['message' => "ดำเนินรายการไม่สำเร็จ กรุณาลองใหม่อีกครั้ง"]);
                exit;
            }
        } else if ($_POST["pay"] == "ชำระออนไลน์") {

            if (empty(trim($_POST["receive_bank"]))) {
                http_response_code(412);
                echo json_encode(['message' => "กรุณาเลือกบัญชีธนาคาร"]);
                exit;
            } else if (empty(trim($_POST["transfer_account_number"]))) {
                http_response_code(412);
                echo json_encode(['message' => "กรุณากรอกเลขบัญชีผู้โอน"]);
                exit;
            } else if (empty(trim($_POST["transfer_owner"]))) {
                http_response_code(412);
                echo json_encode(['message' => "กรุณากรอกชื่อบัญชีผู้โอน"]);
                exit;
            } else if (empty($_POST["transfer_datetime"])) {
                http_response_code(412);
                echo json_encode(['message' => "กรุณากรอกวันเวลาที่โอนตามสลิป"]);
                exit;
            } else if (empty($_FILES["slip"]["name"])) {
                http_response_code(412);
                echo json_encode(['message' => "กรุณาอัพโหลดสลิป"]);
                exit;
            } else {
                $extension = strrchr($_FILES['slip']['name'], '.');
                $file = $_POST["id"] . $extension;
                $dir_target = "../../admin/dist/img/slip/" . $file;

                $sql = "UPDATE notice_payments SET np_status=:status,np_pay=:pay,np_receive_bank=:rb,np_receive_acc=:rcc,np_receive_owner=:ro,np_transfer_bank=:tb,
                np_transfer_acc=:tacc,np_transfer_owner=:to,np_transfer_datetime=:tdt,np_slip=:slip WHERE np_id=:id";
                $stmt = $pdo->prepare($sql);
                $result = $stmt->execute([
                    'status' => "รอตรวจสอบ",
                    'pay' => $_POST["pay"],
                    'rb' => $_POST["receive_bank"],
                    'rcc' => $_POST["receive_account_number"],
                    'ro' => $_POST["receive_owner"],
                    'tb' => $_POST["transfer_bank"],
                    'tacc' => $_POST["transfer_account_number"],
                    'to' => $_POST["transfer_owner"],
                    'tdt' => $_POST["transfer_datetime"],
                    'slip' => $file,
                    'id' => $_POST["id"]
                ]);

                if ($result) {
                    move_uploaded_file($_FILES["slip"]["tmp_name"], $dir_target);
                    http_response_code(200);
                    echo json_encode(['message' => "ดำเนินรายการสำเร็จ"]);
                    exit;
                } else {
                    http_response_code(412);
                    echo json_encode(['message' => "ดำเนินรายการไม่สำเร็จ กรุณาลองใหม่อีกครั้ง"]);
                    exit;
                }
            }
        } else {
            http_response_code(412);
            echo json_encode(['message' => "ไม่ได้เลือกรูปแบบการชำระเงินที่ถูกต้อง"]);
            exit;
        }
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
    exit;
}
