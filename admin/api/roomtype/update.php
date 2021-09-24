<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    if (empty($_POST['name'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลชื่อประเภท']);
        exit;
    } else if (empty($_POST['description'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลคำอธิบาย']);
        exit;
    } else if (empty($_POST['price'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลราคา']);
        exit;
    }

    if (empty($_FILES['img']['name'])) {
        $file = $_POST['old_img'];
    } else {

        $dir_target = "../../dist/img/room/" . $_POST['old_img'];
        unlink($dir_target);

        $extention = strrchr($_FILES['img']['name'], '.');
        $file = uniqid() . $extention;
        $dir_target = "../../dist/img/room/" . $file;
    }

    $sql = "UPDATE roomtypes SET name=:name,type=:type,description=:description,price=:price,img=:img WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'img' => $file,
        'id' => $_POST['id']
    ]);

    if ($result) {

        if(!empty($_FILES['img']['name'])){
          move_uploaded_file($_FILES['img']['tmp_name'], $dir_target);  
        }
        
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "อัพเดตข้อมูลประเภทห้องพัก $_POST[id] สำเร็จ"]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'อัพเดตข้อมูลประเภทห้องพักไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
