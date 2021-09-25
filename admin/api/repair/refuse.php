<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-type:application/json");
    require_once('../connect.php');

    if(empty($_POST['note'])){
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "โปรดระบุสาเหตุที่ปฏิเสธ"]);
        exit;
    }

    $sql = "UPDATE repairs SET status=:status,note=:note WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'status' => "ปฏิเสธ",
        'note' => $_POST['note'],
        'id' => $_POST['id']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "ปฏิเสธรายการแจ้งซ่อม $_POST[id] สำเร็จ"]);
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => "ปฏิเสธไม่สำเร็จ"]);
    }
} else {
    http_response_code(405);
}
