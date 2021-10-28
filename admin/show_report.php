<?php

require_once("permission/access.php");

if (isset($_GET['report']) && !empty($_GET['report'])) {

    require_once("api/connect.php");

    if ($_GET['report'] == "allcus") {
        $sql = "SELECT * FROM customers ORDER BY created DESC";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll();

        $title = "รายชื่อลูกค้าทั้งหมด";
    } else if ($_GET['report'] == "allroom") {
        $sql = "SELECT daily_rooms.id,active,name FROM daily_rooms,roomtypes WHERE daily_rooms.type=roomtypes.id ORDER BY daily_rooms.created DESC";
        $stmt = $pdo->query($sql);
        $data1 = $stmt->fetchAll();

        $sql = "SELECT monthly_rooms.id,active,name FROM monthly_rooms,roomtypes WHERE monthly_rooms.type=roomtypes.id ORDER BY monthly_rooms.created DESC";
        $stmt = $pdo->query($sql);
        $data2 = $stmt->fetchAll();

        $title = "รายชื่อประเภทห้องทั้งหมด";
    } else if ($_GET['report'] == "alldailyroom") {
        $sql = "SELECT daily_rooms.id,active,name FROM daily_rooms,roomtypes WHERE daily_rooms.type=roomtypes.id ORDER BY daily_rooms.created DESC";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll();

        $title = "รายชื่อห้องรายวันทั้งหมด";
    } else if ($_GET['report'] == "allmonthlyroom") {
        $sql = "SELECT monthly_rooms.id,active,name FROM monthly_rooms,roomtypes WHERE monthly_rooms.type=roomtypes.id ORDER BY monthly_rooms.created DESC";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll();

        $title = "รายชื่อห้องรายเดือนทั้งหมด";
    } else if ($_GET['report'] == "allrepair") {
        $sql = "SELECT topic,description,room_id,firstname,lastname,repairs.status,repairs.created FROM repairs,customers WHERE repairs.customer_username=customers.username ORDER BY repairs.created DESC";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll();

        $title = "รายการแจ้งซ่อมทั้งหมด";
    } else if ($_GET['report'] == "usedailyroom") {
        if (isset($_GET['start']) && isset($_GET['end'])) {
            $start = $_GET["start"];
            $end = $_GET["end"];

            $sql = "SELECT daily_books.id,daily_room_id,firstname,lastname,address,phone_number,email,daterange,cost,daily_books.status FROM daily_books,customers WHERE daily_books.customer_username=customers.username AND check_in BETWEEN '$start' AND '$end'";
            $stmt = $pdo->query($sql);
            $data = $stmt->fetchAll();

            $title = "ข้อมูลการใช้งานห้องรายวัน " . $start . " ถึง " . $end;
        } else {
            $sql = "SELECT daily_books.id,daily_room_id,firstname,lastname,address,phone_number,email,daterange,cost,daily_books.status FROM daily_books,customers WHERE daily_books.customer_username=customers.username AND daily_books.status='อยู่ระหว่างการเช็คอิน'";
            $stmt = $pdo->query($sql);
            $data = $stmt->fetchAll();
            $title = "ข้อมูลการใช้งานห้องรายวัน " . date("d-m-Y");
        }
    } else if ($_GET['report'] == "usemonthlyroom") {
        if (isset($_GET['month']) && isset($_GET['year'])) {
            $month = $_GET['month'];
            $year = $_GET['year'];

            $sql = "SELECT * FROM notice_payments,customers WHERE notice_payments.np_customer_username=customers.username AND np_month=:month AND np_year=:year ORDER BY np_created DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'month' => $month,
                'year' => $year
            ]);
            $data = $stmt->fetchAll();

            $title = "ข้อมูลการใช้งานห้องรรายเดือน ".$month." ".$year;
        } else {
            echo "<script>window.history.back()</script>";
        }
    }
} else {
    echo "<script>window.history.back()</script>";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <style>
        @media print {
            @page {
                margin: 2.5cm;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex justify-content-center">
                <h3>หอพักเกศรานครสวรรค์</h3>
            </div>
            <div class="col-12 mt-3 d-flex justify-content-center">
                <h3><?= $title ?></h3>
            </div>
            <div class="col-12 mt-3 d-flex justify-content-center">
                <h4>วันที่พิมพ์: <?= date("d-m-Y") ?></h4>
            </div>

            <div class="col-12 mt-5">
                <?php if ($_GET['report'] == "allcus") : ?>
                    <div class="float-right">
                        <p>ทั้งหมด: <?= count($data) ?> คน</p>
                    </div>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อจริง</th>
                                <th>นามสกุล</th>
                                <th>ที่อยู่</th>
                                <th>เบอร์โทร</th>
                                <th>อีเมล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['firstname'] ?></td>
                                    <td><?= $row['lastname'] ?></td>
                                    <td><?= $row['address'] ?></td>
                                    <td><?= $row['phone_number'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php elseif ($_GET['report'] == "allroom") : ?>
                    <div class="float-right">
                        <p>ทั้งหมด: <?= count($data1) + count($data2) ?> ห้อง</p>
                    </div>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ประเภท</th>
                                <th>เลขห้อง</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data1 as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['active'] ?></td>
                                </tr>
                            <?php } ?>
                            <?php foreach ($data2 as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['active'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php elseif ($_GET['report'] == "alldailyroom") : ?>
                    <div class="float-right">
                        <p>ทั้งหมด: <?= count($data) ?> ห้อง</p>
                    </div>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ประเภท</th>
                                <th>เลขห้อง</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['active'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php elseif ($_GET['report'] == "allmonthlyroom") : ?>
                    <div class="float-right">
                        <p>ทั้งหมด: <?= count($data) ?> ห้อง</p>
                    </div>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ประเภท</th>
                                <th>เลขห้อง</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['active'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php elseif ($_GET['report'] == "allrepair") : ?>
                    <div class="float-right">
                        <p>ทั้งหมด: <?= count($data) ?> รายการ</p>
                    </div>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>วันที่แจ้ง</th>
                                <th>เลขห้อง</th>
                                <th>เรื่อง</th>
                                <th>รายละเอียด</th>
                                <th>ผู้แจ้ง</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['created'] ?></td>
                                    <td><?= $row['room_id'] ?></td>
                                    <td><?= $row['topic'] ?></td>
                                    <td><?= $row['description'] ?></td>
                                    <td><?= $row['firstname'] . " " . $row['lastname'] ?></td>
                                    <td><?= $row['status'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php elseif ($_GET['report'] == "usedailyroom") : ?>
                    <div class="float-right">
                        <p>ทั้งหมด: <?= count($data) ?> รายการ</p>
                    </div>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>เลขห้อง</th>
                                <th>ชื่อลูกค้า</th>
                                <th>ที่อยู่</th>
                                <th>เบอร์โทร</th>
                                <th>อีเมล</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['daily_room_id'] ?></td>
                                    <td><?= $row['firstname'] . " " . $row['lastname'] ?></td>
                                    <td><?= $row['address'] ?></td>
                                    <td><?= $row['phone_number'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['status'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php elseif ($_GET['report'] == "usemonthlyroom") :  ?>
                    <div class="float-right">
                        <p>ทั้งหมด: <?= count($data) ?> รายการ</p>
                    </div>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>หมายเลขห้อง</th>
                                <th>ผู้เช่า</th>
                                <th>ค่าห้อง</th>
                                <th>ค่าน้ำ</th>
                                <th>ค่าไฟ</th>
                                <th>รวมทั้งหมด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row) { ?>
                                <?php
                                $sql = "SELECT * FROM notice_payment_details WHERE npd_np_id='$row[np_id]'";
                                $stmt = $pdo->query($sql);
                                $npd = $stmt->fetchAll();
                                ?>
                                <tr>
                                    <td><?= $row['np_room_id'] ?></td>
                                    <td><?= $row['firstname'] . " " . $row['lastname'] ?></td>
                                    <?php foreach ($npd as $item) { ?>
                                        <td><?= $item['npd_cost'] ?></td>
                                    <?php } ?>
                                    <td><?= number_format($row['np_cost'], 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php endif ?>
            </div>
        </div>
    </div>
</body>

</html>