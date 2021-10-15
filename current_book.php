<?php
session_start();

require_once('api/connect.php');

$sql = "SELECT current_book FROM customers WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['CUSTOMER_USERNAME']]);
$row = $stmt->fetchObject();

$current_book = $row->current_book;

if (!empty($current_book)) {
    $sql = "
        SELECT daily_books.id,customer_username,daterange,duration,check_in,check_out,time,cost,check_in_datetime,daily_room_id,status,note,name,floor,daily_books.created
        FROM daily_books,daily_rooms,roomtypes
        WHERE daily_books.daily_room_id=daily_rooms.id
        AND daily_rooms.type=roomtypes.id
        AND daily_books.id=?
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$current_book]);
    $daily = $stmt->fetchObject();

    if (empty($daily)) {
        $sql = "
            SELECT monthly_books.id,customer_username,schedule_move_in,move_in_date,cost,monthly_room_id,status,note,name,floor,monthly_books.created
            FROM monthly_books,monthly_rooms,roomtypes
            WHERE monthly_books.monthly_room_id=monthly_rooms.id
            AND monthly_rooms.type=roomtypes.id
            AND monthly_books.id = ?
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$current_book]);
        $monthly = $stmt->fetchObject();

        $sql = "SELECT * FROM repairs WHERE room_id=? AND customer_username=? ORDER BY created DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$monthly->monthly_room_id, $_SESSION['CUSTOMER_USERNAME']]);
        $repairs = $stmt->fetchAll();
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
    <title>ข้อมูลห้องพักของฉัน | DORMITORY KESARA</title>


    <?php require_once('layouts/head.php'); ?>

    <style>
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place front is invalid - may break your css so removed */
            padding-top: 100px;
            /* Location of the box - don't know what this does?  If it is to move your modal down by 100px, then just change top below to 100px and remove this*/
            left: 0;
            right: 0;
            /* Full width (left and right 0) */
            top: 0;
            bottom: 0;
            /* Full height top and bottom 0 */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
            z-index: 9999;
            /* Sit on top - higher than any other z-index in your site*/
        }


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
                        <h4>ข้อมูลห้องพักของฉัน</h4>
                        <h2>ดูข้อมูลห้องพัก และแจ้งซ่อมอุปกรณ์ภายในห้องพักของคุณ</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="find-us">
        <div class="container">
            <div class="row">
                <?php if (!empty($current_book)) : ?>

                    <?php if (!empty($daily)) : ?>
                        <div class="col-12 mb-5">
                            <ul class="progressbar">
                                <li class="active">รอการอนุมัติ</li>
                                <li class="<?= ($daily->status == "รอเช็คอิน" || $daily->status == "อยู่ระหว่างการเช็คอิน") ? 'active' : '' ?>">ชำระค่ามัดจำ</li>
                                <li class="<?= ($daily->status == "อยู่ระหว่างการเช็คอิน") ? 'active' : '' ?>">เช็คอิน</li>
                                <li>เช็คเอาท์</li>
                            </ul>
                        </div>

                        <div class="col-12 text-center mb-5">
                            <h1>
                                ชั้น <?= $daily->floor ?> ห้อง <strong style="color:red;"><?= $daily->daily_room_id ?></strong> <?= $daily->name ?>
                            </h1>
                        </div>

                        <div class="col-12">
                            <table class="table table-hover">
                                <tr>
                                    <th>รหัสรายการจอง</th>
                                    <td><?= $daily->id ?></td>
                                </tr>
                                <tr>
                                    <th>วันที่ทำรายการ</th>
                                    <td><?= $daily->created ?></td>
                                </tr>
                                <tr>
                                    <th>ชื่อจริง-นามสกุล</th>
                                    <td><?= $_SESSION['CUSTOMER_FIRSTNAME'] . " " . $_SESSION['CUSTOMER_LASTNAME'] ?></td>
                                </tr>
                                <tr>
                                    <th>ช่วงวันที่</th>
                                    <td><?= $daily->daterange ?></td>
                                </tr>
                                <tr>
                                    <th>ระยะเวลา</th>
                                    <td><?= $daily->duration ?> คืน</td>
                                </tr>
                                <tr>
                                    <th>กำหนดการเช็คอิน</th>
                                    <td><?= $daily->check_in ?> เวลา <?= $daily->time ?> น.</td>
                                </tr>
                                <tr>
                                    <th>กำหนดการเช็คเอาท์</th>
                                    <td><?= $daily->check_out ?> เวลา <?= $daily->time ?> น.</td>
                                </tr>
                                <tr>
                                    <th>ค่ามัดจำ 50% (บาท)</th>
                                    <td><?= number_format($daily->cost / 2, 2) ?></td>
                                </tr>
                                <tr>
                                    <th>ค่าที่พักทั้งหมด (บาท)</th>
                                    <td><?= number_format($daily->cost, 2) ?></td>
                                </tr>
                                <tr>
                                    <th>สถานะ</th>
                                    <td>
                                        <?php if ($daily->status == "รอชำระค่ามัดจำ") : ?>
                                            <span class="badge badge-danger"><?= $daily->status ?></span>
                                            <a style="color:red;" href="javascript:void(0)" onclick="dailyDeposit('<?= $daily->id ?>','<?= $daily->cost / 2 ?>')">คลิกชำระค่ามัดจำ!</a>
                                        <?php else : ?>
                                            <span class="badge badge-primary"><?= $daily->status ?></span>
                                        <?php endif ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>เช็คอินเมื่อ</th>
                                    <td><?= ($daily->check_in_datetime == "" || $daily->check_in_datetime == null) ? 'ยังไม่ได้เช็คอินที่พัก' : $daily->check_in_datetime ?></td>
                                </tr>
                                <tr>
                                    <th>หมายเหตุ</th>
                                    <td><?= $daily->note ?></td>
                                </tr>
                            </table>
                        </div>
                    <?php elseif (!empty($monthly)) : ?>
                        <div class="col-12 mb-5">
                            <ul class="progressbar">
                                <li class="active">รอการอนุมัติ</li>
                                <li class="<?= ($monthly->status == "รอย้ายเข้า" || $monthly->status == "อยู่ระหว่างการเช่าห้อง") ? 'active' : '' ?>">ชำระค่ามัดจำ</li>
                                <li class="<?= ($monthly->status == "อยู่ระหว่างการเช่าห้อง") ? 'active' : '' ?>">ย้ายเข้า</li>
                                <li>ย้ายออก</li>
                            </ul>
                        </div>

                        <div class="col-12 text-center mb-5">
                            <h1>
                                ชั้น <?= $monthly->floor ?> ห้อง <strong style="color:red;"><?= $monthly->monthly_room_id ?></strong> <?= $monthly->name ?>
                            </h1>
                        </div>



                        <div class="col-12">
                            <table class="table table-hover">
                                <tr>
                                    <th>รหัสรายการจอง</th>
                                    <td><?= $monthly->id ?></td>
                                </tr>
                                <tr>
                                    <th>วันที่ทำรายการ</th>
                                    <td><?= $monthly->created ?></td>
                                </tr>
                                <tr>
                                    <th>ชื่อจริง-นามสกุล</th>
                                    <td><?= $_SESSION['CUSTOMER_FIRSTNAME'] . " " . $_SESSION['CUSTOMER_LASTNAME'] ?></td>
                                </tr>
                                <tr>
                                    <th>กำหนดการย้ายของเข้า</th>
                                    <td><?= $monthly->schedule_move_in ?></td>
                                </tr>
                                <tr>
                                    <th>ค่ามัดจำ 50% (บาท)</th>
                                    <td><?= number_format($monthly->cost / 2, 2) ?></td>
                                </tr>
                                <tr>
                                    <th>ค่าที่พักทั้งหมด (บาท)</th>
                                    <td><?= number_format($monthly->cost, 2) ?></td>
                                </tr>
                                <tr>
                                    <th>สถานะ</th>
                                    <td>
                                        <?php if ($monthly->status == "รอชำระค่ามัดจำ") : ?>
                                            <span class="badge badge-danger"><?= $monthly->status ?></span>
                                            <a style="color:red;" href="javascript:void(0)" onclick="monthlyDeposit('<?= $monthly->id ?>','<?= $monthly->cost / 2 ?>')">คลิกชำระค่ามัดจำ!</a>
                                        <?php else : ?>
                                            <span class="badge badge-primary"><?= $monthly->status ?></span>
                                        <?php endif ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>ย้ายเข้าเมื่อ</th>
                                    <td><?= ($monthly->move_in_date == "" || $monthly->move_in_date == null) ? 'ยังไม่ได้ย้ายเข้าที่พัก' : $monthly->move_in_date ?></td>
                                </tr>
                                <tr>
                                    <th>หมายเหตุ</th>
                                    <td><?= $monthly->note ?></td>
                                </tr>
                            </table>


                            <div class="col-12">
                                <div class="text-center mb-5">
                                    <h1>ประวัติการแจ้งซ่อมของคุณ ภายในห้อง <?= $monthly->monthly_room_id ?></h1>
                                    <?php if ($monthly->status == "อยู่ระหว่างการเช่าห้อง") : ?>
                                        <button class="btn btn-secondary" onclick="repair('<?= $monthly->monthly_room_id ?>')">
                                            แจ้งซ่อมอุปกรณ์ภายในห้อง
                                        </button>
                                    <?php endif ?>
                                </div>

                                <?php if (count($repairs) > 0) : ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>วันที่แจ้ง</th>
                                                    <th>ข้อมูลแจ้งซ่อม</th>
                                                    <th>ภาพ</th>
                                                    <th>สถานะ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($repairs as $repair) { ?>
                                                    <tr>
                                                        <td><?= $repair['created'] ?></td>
                                                        <td>
                                                            รหัส: <span class="badge badge-primary"><?= $repair['id'] ?></span>
                                                            <br>
                                                            <hr>
                                                            หัวข้อ: <?= $repair['topic'] ?> <br>
                                                            รายละเอียด: <?= $repair['description'] ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($repair['img'] != "") : ?>
                                                                <button class="btn btn-info" onclick="viewImage('<?= $repair['img'] ?>')">ดูภาพ</button>
                                                            <?php else : ?>
                                                                ไม่มีภาพ
                                                            <?php endif ?>
                                                        </td>
                                                        <td><?= $repair['status'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else : ?>
                                    <div class="alert alert-warning" role="alert">
                                        <h4 class="alert-heading">คุณไม่มีประวัติการแจ้งซ่อมอุปกรณ์ ภายในห้อง <?= $monthly->monthly_room_id ?>!</h4>
                                        <strong>หากมีปัญหาใดๆ สามารถแจ้งให้เราทราบได้ทุกเมื่อ ขอบคุณที่ใช้บริการ</strong>
                                    </div>
                                <?php endif ?>
                            </div>

                        </div>
                    <?php endif ?>
                <?php else : ?>
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">คุณไม่ได้กำลังใช้งานห้องพักใดๆ ในขณะนี้</h4>
                        <strong>หากเมื่อสักครู่ท่านกำลังอยู่ระหว่างการดำเนินการจองที่พัก เป็นได้ว่าผู้ดูแลระบบได้ปฏิเสธรายการของท่านเช็คประวัติการใช้งานของท่าน <a href="mybooking.php">ประวัติการใช้งาน</a> สามารถจองห้องพักใหม่ได้ <a href="daily_book.php">แบบรายวัน</a> และ <a href="monthly_book.php">แบบรายเดือน</a></strong>
                    </div>
                <?php endif ?>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="myModalBody">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once('layouts/footer.php'); ?>


    <script src="functions/current_book.js"></script>
</body>

</html>