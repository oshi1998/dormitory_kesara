<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-type:application/json");
    require_once("../connect.php");

    if (empty($_POST['room_id'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณาเลือกห้องพัก"]);
        exit;
    } elseif (empty(trim($_POST['manager_name']))) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณากรอกชื่อผู้จัดการ"]);
        exit;
    } elseif (empty($_POST['expired_date'])) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณาเลือกวันที่ชำระเงินสุดท้าย"]);
        exit;
    } elseif (empty(trim($_POST['fine']))) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณากรอกค่าปรับ"]);
        exit;
    } elseif (empty(trim($_POST["npd"][1]["cost"]))) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณากรอกค่าน้ำ"]);
        exit;
    } elseif (empty(trim($_POST["npd"][2]["cost"]))) {
        http_response_code(412);
        echo json_encode(['message' => "กรุณากรอกค่าไฟ"]);
        exit;
    } else {

        $np_id = "NP" . date("Ymd") . "-" . rand(1, 999);

        $count_npd = intval(count($_POST["npd"]));
        $cost = 0;

        for ($i = 0; $i < $count_npd; $i++) {
            if (empty(trim($_POST["npd"][$i]["name"])) || empty(trim($_POST["npd"][$i]["cost"]))) {
                unset($_POST["npd"][$i]);
            } else {
                $cost += floatval($_POST["npd"][$i]["cost"]);
            }
        }

        $sql = "INSERT INTO notice_payments (np_id,np_customer_username,np_manager_name,np_room_id,np_month,np_year,np_cost,np_fine,np_expired_date,np_status) VALUES
        (:id,:customer,:manager,:room,:month,:year,:cost,:fine,:ed,:status)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'id' => $np_id,
            'customer' => $_POST['customer_username'],
            'manager' => $_POST['manager_name'],
            'room' => $_POST['room_id'],
            'month' => $_POST['month'],
            'year' => $_POST['year'],
            'cost' => $cost,
            'fine' => $_POST['fine'],
            'ed' => $_POST['expired_date'],
            'status' => "รอชำระเงิน"
        ]);

        if ($result) {

            $npd_query = 0;

            foreach ($_POST["npd"] as $item) {
                $sql = "INSERT INTO notice_payment_details (npd_np_id,npd_name,npd_cost) VALUES (:id,:name,:cost)";
                $stmt = $pdo->prepare($sql);
                $result = $stmt->execute([
                    'id' => $np_id,
                    'name' => $item['name'],
                    'cost' => $item['cost']
                ]);

                if ($result) {
                    $npd_query++;
                }
            }

            if ($npd_query == count($_POST["npd"])) {
                http_response_code(200);
                echo json_encode(['message' => "สร้างบิลชำระเงินสำเร็จ"]);
                exit;
            } else {
                http_response_code(412);
                echo json_encode(['message' => "สร้างบิลชำระเงินไม่สำเร็จ"]);
                exit;
            }
        } else {
            http_response_code(412);
            echo json_encode(['message' => "สร้างบิลชำระเงินไม่สำเร็จ"]);
            exit;
        }
    }
} else {
    http_response_code(405);
    echo "รีเควสไม่ถูกต้อง";
}
