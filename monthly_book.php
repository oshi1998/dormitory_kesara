<?php
session_start();

require_once('api/connect.php');


$sql = "SELECT current_book FROM customers WHERE id_card = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['CUSTOMER_ID']]);
$row = $stmt->fetchObject();

if (empty($row->current_book)) {

    if (empty($_GET)) {
        $sql = "SELECT id,name FROM roomtypes WHERE type='รายเดือน'";
        $stmt = $pdo->query($sql);
        $types = $stmt->fetchAll();
    } else {
        if (isset($_GET['step2'])) {
            if (isset($_SESSION['MYBOOK_MONTH']) && !empty($_SESSION['MYBOOK_MONTH'])) {
                $sql = "
                    SELECT monthly_rooms.id,floor,name,description,price,img FROM monthly_rooms,roomtypes WHERE monthly_rooms.type=roomtypes.id
                    AND monthly_rooms.active=:active
                    AND monthly_rooms.type=:type
                    AND monthly_rooms.id NOT IN (SELECT monthly_room_id FROM monthly_books WHERE monthly_books.status!=:status)
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'active' => "พร้อมใช้งาน",
                    'type' => $_SESSION['MYBOOK_MONTH']['ROOM_TYPE'],
                    'status' => "ยกเลิก"
                ]);

                $rooms = $stmt->fetchAll();

                $type_name = $rooms[0]['name'];
            } else {
                header('location:monthly_book.php');
            }
        } else if (isset($_GET['step3'])) {
            if (isset($_SESSION['MYBOOK_MONTH']['ROOM_ID']) && !empty($_SESSION['MYBOOK_MONTH']['ROOM_ID'])) {
                $sql = "SELECT name FROM roomtypes WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$_SESSION['MYBOOK_MONTH']['ROOM_TYPE']]);
                $row = $stmt->fetchObject();
                $room_type = $row->name;
            } else {
                header('location:monthly_book.php?step2');
            }
        } else {
            header('location:monthly_book.php');
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
    <title>จองห้องพักแบบรายเดือน | DORMITORY KESARA</title>


    <?php require_once('layouts/head.php'); ?>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="vendor/daterangepicker/daterangepicker.css">

    <style>
        #myModal .modal-dialog {
            -webkit-transform: translate(0, -50%);
            -o-transform: translate(0, -50%);
            transform: translate(0, -50%);
            top: 50%;
            margin: 0 auto;
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
                        <h4>จองห้องพักแบบรายเดือน</h4>
                        <h2>ระบบจองห้องพักแบบรายเดือน</h2>
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
                        <li class="active">เลือกรูปแบบห้อง</li>
                        <li class="<?= (isset($_GET['step2']) || isset($_GET['step3']) || isset($_GET['step4'])) ? 'active' : '' ?>">ค้นหา & เลือกห้องพัก</li>
                        <li class="<?= (isset($_GET['step3']) || isset($_GET['step4'])) ? 'active' : '' ?>">ตรวจสอบ</li>
                        <li class="<?= (isset($_GET['step3']) || isset($_GET['step4'])) ? 'active' : '' ?>">เสร็จสิ้น</li>
                    </ul>
                </div>


                <div class="col-12">
                    <?php if (empty($_GET)) : ?>
                        <div class="form-group">
                            <label>เลือกรูปแบบห้อง</label>
                            <select class="form-control" id="inputType">
                                <option value="" selected disabled>--- เลือกรูปแบบห้อง ---</option>
                                <?php foreach ($types as $type) { ?>
                                    <option value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>กำหนดการที่คุณจะย้ายของเข้า</label>
                            <input type="datetime-local" class="form-control" id="inputMoveIn">
                        </div>

                        <br>

                        <div id="showAlert1"></div>

                        <br>

                        <div class="float-right">
                            <button class="btn btn-success" onclick="goStep2()">ค้นหา & เลือกห้องพัก</button>
                        </div>
                    <?php else : ?>
                        <?php if (isset($_GET['step2'])) : ?>

                            <h1 class="text-center mb-5">
                                ระบบแสดงรายชื่อห้องพัก <?= $type_name ?> <br>
                                ที่พร้อมให้บริการขณะนี้ เท่านั้น
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
                                    <a href="monthly_book.php" class="btn btn-primary">เลือกรูปแบบห้องใหม่</a>
                                    <?php if (!empty($_SESSION['MYBOOK_MONTH']['ROOM_ID'])) : ?>
                                        <a href="daily_book.php?step3" class="btn btn-success">กลับไป หน้าตรวจสอบ</a>
                                    <?php endif ?>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-warning" role="alert">
                                    <h4 class="alert-heading">ขออภัย! ไม่มีห้องพัก <?= $type_name ?> พร้อมบริการท่านในขณะนี้</h4>
                                    <strong>ท่านสามารถกดปุ่ม "เลือกรูปแบบห้องใหม่" ข้างล่าง เพื่อเลือกรูปแบบห้องใหม่ ได้ </strong>
                                    <hr>
                                    <p class="mb-0">
                                        <a class="btn btn-primary" href="monthly_book.php">เลือกรูปแบบห้องใหม่</a>
                                    </p>
                                </div>
                            <?php endif ?>

                        <?php elseif (isset($_GET['step3'])) : ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th>รหัสรายการจอง</th>
                                    <td><?= $_SESSION['MYBOOK_MONTH']['ID'] ?></td>
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
                                    <td><?= $_SESSION['MYBOOK_MONTH']['ROOM_ID'] ?></td>
                                </tr>
                                <tr>
                                    <th>กำหนดการที่จะย้ายของเข้า</th>
                                    <td><?= date("Y-m-d เวลา H:i น.",strtotime($_SESSION['MYBOOK_MONTH']['SCHEDULE_MOVE_IN'])) ?></td>
                                </tr>
                                <tr>
                                    <th>ค่ามัดจำจองที่พัก 50% (บาท)</th>
                                    <td><?= number_format($_SESSION['MYBOOK_MONTH']['COST'] / 2, 2) ?></td>
                                </tr>
                                <tr>
                                    <th>ค่าที่พักทั้งหมด (บาท)</th>
                                    <td><?= number_format($_SESSION['MYBOOK_MONTH']['COST'], 2) ?></td>
                                </tr>
                            </table>

                            <div class="float-right">
                                <a href="monthly_book.php?step2" class="btn btn-primary">เลือกห้องใหม่</a>
                                <button class="btn btn-success" onclick="book()">ดำเนินการจอง</button>
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                </div>

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
    <script src="functions/monthly_book.js"></script>
</body>

</html>