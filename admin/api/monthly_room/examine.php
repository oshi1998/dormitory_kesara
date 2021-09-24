<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    $sql = "SELECT id FROM daily_rooms WHERE id = ? UNION SELECT id FROM monthly_rooms WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['id'],$_POST['id']]);
    $row = $stmt->fetchAll();

    if (empty($row)) {
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "เลขห้อง $_POST[id] สามารถใช้งานได้"]);
    } else {
        http_response_code(200);
        echo json_encode(['status' => false, 'message' => "เลขห้อง $_POST[id] มีอยู่แล้วในระบบ"]);
    }
} else {
    http_response_code(405);
}
