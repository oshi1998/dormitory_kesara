<?php
session_start();

require_once('api/connect.php');

$sql = "SELECT * FROM daily_books WHERE customer_id=? ORDER BY created DESC";
$stmt =  $pdo->prepare($sql);
$stmt->execute([$_SESSION['CUSTOMER_ID']]);
$dailys = $stmt->fetchAll();

$sql = "SELECT * FROM monthly_books WHERE customer_id=? ORDER BY created DESC";
$stmt =  $pdo->prepare($sql);
$stmt->execute([$_SESSION['CUSTOMER_ID']]);
$monthlys = $stmt->fetchAll();

$sql = "SELECT * FROM repairs WHERE customer_id=? ORDER BY created DESC";
$stmt =  $pdo->prepare($sql);
$stmt->execute([$_SESSION['CUSTOMER_ID']]);
$repairs = $stmt->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ประวัติการใช้งาน | DORMITORY KESARA</title>


    <?php require_once('layouts/head.php'); ?>
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <?php require_once('layouts/preloader.php'); ?>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <?php require_once('layouts/menu.php'); ?>

    <!-- Page Content -->
    <div class="page-heading contact-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>ประวัติการใช้งาน</h4>
                        <h2>ประวัติการใช้งานทั้งหมดของคุณ</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="find-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-daily-tab" data-toggle="pill" href="#v-pills-daily" role="tab" aria-controls="v-pills-daily" aria-selected="true">ประวัติการจองห้องรายวัน</a>
                        <a class="nav-link" id="v-pills-monthly-tab" data-toggle="pill" href="#v-pills-monthly" role="tab" aria-controls="v-pills-monthly" aria-selected="false">ประวัติการจองห้องรายเดือน</a>
                        <a class="nav-link" id="v-pills-repair-tab" data-toggle="pill" href="#v-pills-repair" role="tab" aria-controls="v-pills-repair" aria-selected="false">ประวัติการแจ้งซ่อมอุปกรณ์</a>
                    </div>
                </div>
                <div class="col-lg-9 col-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-daily" role="tabpanel" aria-labelledby="v-pills-daily-tab">
                            <?php if (count($dailys) > 0) : ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ทำรายการวันที่</th>
                                                <th>รหัส</th>
                                                <th>ช่วงวันที่</th>
                                                <th>เลขห้อง</th>
                                                <th>ค่าห้องพัก/คืน</th>
                                                <th>สถานะ</th>
                                                <th>หมายเหตุ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($dailys as $daily) { ?>
                                                <tr>
                                                    <td><?= $daily['created'] ?></td>
                                                    <td><?= $daily['id'] ?></td>
                                                    <td><?= $daily['daterange'] ?></td>
                                                    <td><?= $daily['daily_room_id'] ?></td>
                                                    <td><?= $daily['cost'] ?></td>
                                                    <td><?= $daily['status'] ?></td>
                                                    <td><?= $daily['note'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>ขออภัย!</strong> คุณไม่มีประวัติการจองห้องพักรายวัน <a href="daily_book.php">ลองจองห้องพักรายวัน คลิก!</a>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="tab-pane fade" id="v-pills-monthly" role="tabpanel" aria-labelledby="v-pills-monthly-tab">
                            <?php if (count($monthlys) > 0) : ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ทำรายการวันที่</th>
                                                <th>รหัส</th>
                                                <th>วันที่ย้ายเข้า</th>
                                                <th>วันที่ย้ายออก</th>
                                                <th>เลขห้อง</th>
                                                <th>ค่าห้องพัก/เดือน</th>
                                                <th>สถานะ</th>
                                                <th>หมายเหตุ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($monthlys as $month) { ?>
                                                <tr>
                                                    <td><?= $month['created'] ?></td>
                                                    <td><?= $month['id'] ?></td>
                                                    <td>
                                                        <?= ($month['move_in_date'] == "" || $month['move_in_date'] == null) ? 'ไม่มีข้อมูลย้ายเข้า' : $month['move_in_date'] ?>
                                                    </td>
                                                    <td>
                                                        <?= ($month['move_out_date'] == "" || $month['move_out_date'] == null) ? 'ไม่มีข้อมูลย้ายออก' : $month['move_out_date'] ?>
                                                    </td>
                                                    <td><?= $month['monthly_room_id'] ?></td>
                                                    <td><?= $month['cost'] ?></td>
                                                    <td><?= $month['status'] ?></td>
                                                    <td><?= $month['note'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>ขออภัย!</strong> คุณไม่มีประวัติการจองห้องพักรายเดือน <a href="monthly_book.php">ลองจองห้องพักรายเดือน คลิก!</a>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="tab-pane fade" id="v-pills-repair" role="tabpanel" aria-labelledby="v-pills-repair-tab">
                            <?php if (count($repairs) > 0) : ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ทำรายการวันที่</th>
                                                <th>รหัส</th>
                                                <th>หัวข้อ</th>
                                                <th>รายละเอียด</th>
                                                <th>เลขห้อง</th>
                                                <th>สถานะ</th>
                                                <th>หมายเหตุ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($repairs as $repair) { ?>
                                                <tr>
                                                    <td><?= $repair['created'] ?></td>
                                                    <td><?= $repair['id'] ?></td>
                                                    <td><?= $repair['topic'] ?></td>
                                                    <td><?= $repair['description'] ?></td>
                                                    <td><?= $repair['room_id'] ?></td>
                                                    <td><?= $repair['status'] ?></td>
                                                    <td><?= $repair['note'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>ขออภัย!</strong> คุณไม่มีประวัติการแจ้งซ่อมอุปกรณ์
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Footer -->
    <?php require_once('layouts/footer.php'); ?>


    <script src="functions/mybooking.js"></script>
</body>

</html>