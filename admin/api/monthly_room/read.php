<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');


    $sql = "SELECT monthly_rooms.id,name,floor,active,img_position,roomtypes.type FROM monthly_rooms,roomtypes WHERE monthly_rooms.type=roomtypes.id ORDER BY monthly_rooms.created DESC";
    $result = $pdo->query($sql);

    if ($result) {
        $row = $result->fetchAll();
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "โหลดข้อมูลห้องพักสำเร็จ", 'data' => $row]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'โหลดข้อมูลห้องพักไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
