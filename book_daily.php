<?php
session_start();

require_once('api/connect.php');


$sql = "SELECT current_book FROM customers WHERE id_card = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['CUSTOMER_ID']]);
$row = $stmt->fetchObject();

if (empty($row->current_book)) {
    $sql = "SELECT * FROM roomtypes WHERE name='รายวัน (แอร์)'";
    $stmt = $pdo->query($sql);
    $type = $stmt->fetchObject();
}else{
    echo "<script>alert('คุณอยู่ระหว่างการใช้งาน ไม่สามารถจองได้ในขณะนี้');window.location='mybooking.php'</script>";
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

    <link rel="stylesheet" href="vendor/daterangepicker/daterangepicker.css">

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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            แบบฟอร์มการขอจองห้องพักรายวัน <strong>DORMITORY</strong> <strong style="color:red;">KESARA</strong>
                        </div>
                        <div class="card-body">
                            <form id="dailyBookForm">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">ช่วงวันที่</label>
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
                                    <label class="col-sm-2 col-form-label">เวลา</label>
                                    <div class="col-sm-10">
                                        <input type="time" class="form-control" name="time" id="inputTime" required>
                                    </div>
                                </div>

                                <br>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">ค่าห้อง</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="cost" id="cost" value="<?= $type->price ?>" readonly>
                                    </div>
                                </div>

                                <div id="showAlert1"></div>

                                <br>

                                <div class="form-group float-left">
                                    <a target="_blank" href="room.php">ดูรายละเอียดห้องพัก?</a>
                                </div>

                                <div class="form-group float-right">

                                    <button type="button" class="btn btn-info" id="searchBtn" onclick="searchRoom('<?= $type->id ?>')">ตรวจสอบห้องว่าง</button>
                                    <button type="button" class="btn btn-success" id="submitBtn" onclick="submitDailyBook()" disabled>ส่งแบบฟอร์ม</button>
                                    <button type="button" class="btn btn-danger" id="cancelBtn" onclick="cancel()" disabled>ยกเลิก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once('layouts/footer.php'); ?>
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <script src="functions/book_daily.js"></script>
</body>

</html>