<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    header("Content-Type:application/json");
    require_once('../connect.php');

    if (empty($_POST['name'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลชื่อธนาคาร']);
        exit;
    } else if (empty($_POST['account_number'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกเลขบัญชี']);
        exit;
    } else if (empty($_POST['branch'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลสาขา']);
        exit;
    } else if (empty($_POST['holder'])) {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'กรุณากรอกข้อมูลเจ้าของบัญชี']);
        exit;
    }

    if (empty($_FILES['img']['name'])) {
        $file = $_POST['old_img'];
    } else {

        $dir_target = "../../dist/img/bank/" . $_POST['old_img'];
        unlink($dir_target);

        $extention = strrchr($_FILES['img']['name'], '.');
        $file = uniqid() . $extention;
        $dir_target = "../../dist/img/bank/" . $file;
    }

    $sql = "UPDATE banks SET name=:name,account_number=:acc,branch=:branch,holder=:holder,img=:img WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'name' => $_POST['name'],
        'acc' => $_POST['account_number'],
        'branch' => $_POST['branch'],
        'holder' => $_POST['holder'],
        'img' => $file,
        'id' => $_POST['id']
    ]);

    if ($result) {

        if(!empty($_FILES['img']['name'])){
          move_uploaded_file($_FILES['img']['tmp_name'], $dir_target);  
        }
        
        http_response_code(200);
        echo json_encode(['status' => true, 'message' => "อัพเดตข้อมูลบัญชีธนาคาร $_POST[id] สำเร็จ"]);
        exit;
    } else {
        http_response_code(412);
        echo json_encode(['status' => false, 'message' => 'อัพเดตข้อมูลบัญชีธนาคารไม่สำเร็จ']);
        exit;
    }
} else {
    http_response_code(405);
}
