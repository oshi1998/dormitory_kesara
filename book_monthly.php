<?php
session_start();

require_once('api/connect.php');

$sql = "SELECT id,name FROM roomtypes ORDER BY created DESC";
$stmt = $pdo->query($sql);
$roomtypes = $stmt->fetchAll();

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
                            1. ระบุวันที่เช็คอิน - เช็คเอาท์
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">ช่วงวันที่</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="daterange" readonly>
                                </div>
                            </div>

                            <br>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">ระยะเวลา (คืน)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="duration" value="1" readonly>
                                </div>
                            </div>

                            <br>

                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">เวลา</label>
                                <div class="col-sm-10">
                                    <input type="time" class="form-control" name="time" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once('layouts/footer.php'); ?>
    <script src="functions/book.js"></script>
</body>

</html>