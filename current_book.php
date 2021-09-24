<?php
session_start();

require_once('api/connect.php');

$sql = "SELECT current_book FROM customers WHERE id_card = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['CUSTOMER_ID']]);
$row = $stmt->fetchObject();

$current_book = $row->current_book;

if (!empty($current_book)) {
    $sql = "SELECT * FROM daily_books WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$current_book]);
    $book = $stmt->fetchObject();

    if (empty($book)) {
        $sql = "SELECT * FROM monthly_books WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$current_book]);
        $book = $stmt->fetchObject();
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ข้อมูลการใช้งานขณะนี้ | DORMITORY KESARA</title>


    <?php require_once('layouts/head.php'); ?>

    <style>
        .progressbar {
            counter-reset: step;
        }

        .progressbar li {
            list-style-type: none;
            width: 25%;
            float: left;
            font-size: 16px;
            position: relative;
            text-align: center;
            text-transform: uppercase;
            color: #7d7d7d;
        }

        .progressbar li:before {
            width: 30px;
            height: 30px;
            content: counter(step);
            counter-increment: step;
            line-height: 30px;
            border: 2px solid #7d7d7d;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            background-color: white;
        }

        .progressbar li:after {
            width: 100%;
            height: 2px;
            content: '';
            position: absolute;
            background-color: #7d7d7d;
            top: 15px;
            left: -50%;
            z-index: -1;
        }

        .progressbar li:first-child:after {
            content: none;
        }

        .progressbar li.active {
            color: green;
        }

        .progressbar li.active:before {
            border-color: #55b776;
        }

        .progressbar li.active+li:after {
            background-color: #55b776;
        }
    </style>
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
                        <h4>ข้อมูลการใช้งาน</h4>
                        <h2>ข้อมูลการใช้งานขณะนี้ของคุณ</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="find-us">
        <div class="container">
            <div class="row">
                <?php if (!empty($current_book)) : ?>
                    <div class="col-12 mb-5">
                        <ul class="progressbar">
                            <li class="active">รอการอนุมัติ</li>
                            <li>ชำระค่ามัดจำ</li>
                            <li>เช็คอิน</li>
                            <li>เช็คเอาท์</li>
                        </ul>
                    </div>

                    <div class="col-12">
                        <table class="table table-hover">
                            <tr>
                                <th>รหัสรายการจอง</th>
                                <td><?= $book->id ?></td>
                            </tr>
                            <tr>
                                <th>วันที่ทำรายการ</th>
                                <td><?= $book->created ?></td>
                            </tr>
                            <tr>
                                <th>ชื่อจริง-นามสกุล</th>
                                <td><?= $_SESSION['CUSTOMER_FIRSTNAME'] . " " . $_SESSION['CUSTOMER_LASTNAME'] ?></td>
                            </tr>
                            <tr>
                                <th>ช่วงวันที่</th>
                                <td><?= $book->daterange ?></td>
                            </tr>
                            <tr>
                                <th>ระยะเวลา</th>
                                <td><?= $book->duration ?> คืน</td>
                            </tr>
                            <tr>
                                <th>เช็คอิน</th>
                                <td><?= $book->check_in ?> เวลา <?= $book->time ?> น.</td>
                            </tr>
                            <tr>
                                <th>เช็คเอาท์</th>
                                <td><?= $book->check_out ?> เวลา <?= $book->time ?> น.</td>
                            </tr>
                            <tr>
                                <th>ค่ามัดจำ 50% (บาท)</th>
                                <td><?= number_format($book->cost / 2, 2) ?></td>
                            </tr>
                            <tr>
                                <th>ค่าที่พักทั้งหมด (บาท)</th>
                                <td><?= number_format($book->cost, 2) ?></td>
                            </tr>
                            <tr>
                                <th>สถานะ</th>
                                <td>
                                    <span class="badge badge-primary"><?= $book->status ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th>หมายเหตุ</th>
                                <td><?= $book->note ?></td>
                            </tr>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">คุณไม่ได้กำลังใช้งานห้องพักใดๆ ในขณะนี้</h4>
                        <strong>หากเมื่อสักครู่ท่านกำลังอยู่ระหว่างการดำเนินการจองที่พัก เป็นได้ว่าผู้ดูแลระบบได้ปฏิเสธรายการของท่านเช็คประวัติการใช้งานของท่าน <a href="mybooking.php">ประวัติการใช้งาน</a> สามารถจองห้องพักใหม่ได้ <a href="daily_book.php">แบบรายวัน</a> และ <a href="monthly_book.php">แบบรายเดือน</a></strong>
                    </div>
                <?php endif ?>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once('layouts/footer.php'); ?>


    <script src="functions/mybooking.js"></script>
</body>

</html>