<?php
session_start();

require_once('api/connect.php');


$sql = "SELECT current_book FROM customers WHERE id_card = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['CUSTOMER_ID']]);
$row = $stmt->fetchObject();

if (empty($row->current_book)) {

    if (empty($_GET)) {
        $sql = "SELECT id,name FROM roomtypes WHERE type='รายวัน'";
        $stmt = $pdo->query($sql);
        $types = $stmt->fetchAll();
    } else {
        if (isset($_GET['step2'])) {
            if (!isset($_SESSION['MYBOOK']) || empty($_SESSION['MYBOOK'])) {
                header('location:daily_book.php');
            } else {
                $sql = "SELECT daily_rooms.id,name,description,img,price,floor FROM daily_rooms,roomtypes
                WHERE daily_rooms.type=roomtypes.id
                AND daily_rooms.type = :type
                AND daily_rooms.active = :active
                AND daily_rooms.id NOT IN
                (SELECT daily_books.daily_room_id FROM daily_books WHERE :checkin_date < check_out AND :checkout_date > check_in AND status != :status)";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'type' => $_SESSION['MYBOOK']['ROOM_TYPE'],
                    'active' => "พร้อมใช้งาน",
                    'checkin_date' => $_SESSION['MYBOOK']['CHECK_IN'],
                    'checkout_date' => $_SESSION['MYBOOK']['CHECK_OUT'],
                    'status' => 'ยกเลิก'
                ]);

                $rooms = $stmt->fetchAll();
            }
        } else if (isset($_GET['step3'])) {
            if (!isset($_SESSION['MYBOOK']) || empty($_SESSION['MYBOOK'])) {
                header('location:daily_book.php');
            } else {
                if (!empty($_SESSION['MYBOOK']['ROOM_ID'])) {
                    $sql = "SELECT name FROM roomtypes WHERE id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$_SESSION['MYBOOK']['ROOM_TYPE']]);
                    $row = $stmt->fetchObject();
                    $room_type = $row->name;
                } else {
                    header('location:daily_book.php?step2');
                }
            }
        } else {
            header('location:daily_book.php');
        }
    }
} else {
    echo "<script>alert('คุณอยู่ระหว่างการใช้บริการห้องพักของเรา จึงไม่สามารถจองได้ในขณะนี้');window.location='current_book.php'</script>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>จองห้องพักแบบรายวัน | DORMITORY KESARA</title>


    <?php require_once('layouts/head.php'); ?>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="vendor/daterangepicker/daterangepicker.css">

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
                        <h4>จองห้องพักแบบรายวัน</h4>
                        <h2>ระบบจองห้องพักแบบรายวัน</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="find-us">
        <div class="container">
            <div class="row">

                <div class="col-12 mb-5">
                    <ul class="progressbar">
                        <li class="active">ข้อมูลเบื้องต้น</li>
                        <li class="<?= (isset($_GET['step2']) || isset($_GET['step3']) || isset($_GET['step4'])) ? 'active' : '' ?>">ค้นหา & เลือกห้องพัก</li>
                        <li class="<?= (isset($_GET['step3']) || isset($_GET['step4'])) ? 'active' : '' ?>">ตรวจสอบ</li>
                        <li class="<?= (isset($_GET['step3']) || isset($_GET['step4'])) ? 'active' : '' ?>">เสร็จสิ้น</li>
                    </ul>
                </div>

                <div class="col-12">
                    <?php if (empty($_GET)) : ?>
                        <div class="card">
                            <div class="card-header">
                                ข้อมูลเบื้องต้น
                            </div>
                            <div class="card-body">
                                <form id="dailyBookForm">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">เลือกช่วงวันที่ (คลิกช่องเพื่อเลือก)</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="daterange" id="inputDateRange" readonly>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">ระยะเวลา (คืน)</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="duration" value="1" readonly>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">เช็คอิน</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="checkin" readonly>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">เช็คเอาท์</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="checkout" readonly>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">เลือกเวลา</label>
                                        <div class="col-sm-10">
                                            <input type="time" class="form-control" name="time" id="inputTime" required>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">เลือกชนิดห้องรายวัน </label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="type" id="inputType" required>
                                                <option value="" selected disabled>--- เลือกชนิดห้อง ---</option>
                                                <?php foreach ($types as $type) { ?>
                                                    <option value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <br>

                                    <div id="showAlert1"></div>

                                    <br>

                                    <div class="float-right">
                                        <button type="button" class="btn btn-success" onclick="goStep2()">ค้นหา & เลือกห้องพัก</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php elseif (isset($_GET['step2'])) : ?>

                        <h1 class="text-center mb-5">
                            ระบบแสดงห้องพักที่พร้อมใช้งาน ในช่วงวันที่ <br>
                            <?= $_SESSION['MYBOOK']['DATERANGE'] ?> เท่านั้น
                        </h1>

                        <?php if (count($rooms) > 0) : ?>

                            <div class="row">
                                <?php foreach ($rooms as $room) { ?>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="product-item">
                                            <a href="javascript:void(0)" onclick="viewDetail('<?= $room['id'] ?>')">
                                                <img src="admin/dist/img/room/<?= $room['img'] ?>">
                                            </a>
                                            <div class="down-content">
                                                <a href="javascript:void(0)" onclick="viewDetail('<?= $room['id'] ?>')">
                                                    <h4><?= $room['id'] ?> (ชั้น <?= $room['floor'] ?>)</h4>
                                                </a>
                                                <h6><?= number_format($room['price']) ?> บาท</h6>
                                                <p><?= $room['description'] ?></p>

                                                <div class="d-flex justify-content-between">
                                                    <a href="javascript:void(0)" onclick="viewDetail('<?= $room['id'] ?>')">เพิ่มเติม</a>
                                                    <a href="javascript:void(0)" onclick="goStep3('<?= $room['id'] ?>','<?= $room['price'] ?>')">เลือกห้องนี้</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="text-center">
                                <a href="daily_book.php" class="btn btn-primary">กรอกข้อมูลเบื้องต้นใหม่</a>
                                <?php if (!empty($_SESSION['MYBOOK']['ROOM_ID'])) : ?>
                                    <a href="daily_book.php?step3" class="btn btn-success">กลับไป หน้าตรวจสอบ</a>
                                <?php endif ?>
                            </div>
                        <?php else : ?>
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading">ขออภัย! ไม่มีห้องพักพร้อมบริการท่าน ในช่วงวันที่ <?= $_SESSION['MYBOOK']['DATERANGE'] ?></h4>
                                <strong>ท่านสามารถกดปุ่ม "กรอกข้อมูลเบื้องต้นใหม่" ข้างล่าง เพื่อกรอกข้อมูลใหม่ ได้ </strong>
                                <hr>
                                <p class="mb-0">
                                    <a class="btn btn-primary" href="daily_book.php">กรอกข้อมูลเบื้องต้นใหม่</a>
                                </p>
                            </div>
                        <?php endif ?>
                    <?php elseif (isset($_GET['step3'])) : ?>
                        <table class="table table-bordered">
                            <tr>
                                <th>รหัสรายการจอง</th>
                                <td><?= $_SESSION['MYBOOK']['ID'] ?></td>
                            </tr>
                            <tr>
                                <th>ชื่อ-นามสกุล</th>
                                <td><?= $_SESSION['CUSTOMER_FIRSTNAME'] . "  " . $_SESSION['CUSTOMER_LASTNAME'] ?></td>
                            </tr>
                            <tr>
                                <th>รูปแบบห้อง</th>
                                <td><?= $room_type ?></td>
                            </tr>
                            <tr>
                                <th>ห้อง</th>
                                <td><?= $_SESSION['MYBOOK']['ROOM_ID'] ?></td>
                            </tr>
                            <tr>
                                <th>ช่วงวันที่</th>
                                <td><?= $_SESSION['MYBOOK']['DATERANGE'] ?></td>
                            </tr>
                            <tr>
                                <th>ระยะเวลา (คืน)</th>
                                <td><?= $_SESSION['MYBOOK']['DURATION'] ?></td>
                            </tr>
                            <tr>
                                <th>เช็คอิน</th>
                                <td><?= $_SESSION['MYBOOK']['CHECK_IN'] ?> เวลา <?= $_SESSION['MYBOOK']['TIME'] ?> น.</td>
                            </tr>
                            <tr>
                                <th>เช็คเอาท์</th>
                                <td><?= $_SESSION['MYBOOK']['CHECK_OUT'] ?> เวลา <?= $_SESSION['MYBOOK']['TIME'] ?> น.</td>
                            </tr>
                            <tr>
                                <th>ค่ามัดจำจองที่พัก 50% (บาท)</th>
                                <td><?= number_format($_SESSION['MYBOOK']['COST'] / 2,2) ?></td>
                            </tr>
                            <tr>
                                <th>ค่าที่พักทั้งหมด (บาท)</th>
                                <td><?= number_format($_SESSION['MYBOOK']['COST'],2) ?></td>
                            </tr>
                        </table>

                        <div class="float-right">
                            <a href="daily_book.php?step2" class="btn btn-primary">เลือกห้องใหม่</a>
                            <button class="btn btn-success" onclick="book()">ดำเนินการจอง</button>
                        </div>
                    <?php endif ?>
                </div>
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
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <script src="functions/daily_book.js"></script>
</body>

</html>