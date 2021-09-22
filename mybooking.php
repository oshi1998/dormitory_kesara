<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ข้อมูลการใช้งาน | DORMITORY KESARA</title>


    <?php require_once('layouts/head.php'); ?>
</head>

<body onload="loadMyCurrentBooking('<?= $_SESSION['CUSTOMER_ID'] ?>'),loadMyHistoryBooking('<?= $_SESSION['CUSTOMER_ID'] ?>')">

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
                        <h2>ข้อมูลการใช้งานขณะนี้ และประวัติการใช้งานทั้งหมดของคุณ</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="find-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header">
                            ข้อมูลการใช้งานปัจจุบัน
                        </div>
                        <div class="card-body" id="currentBooking">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12">
                    <div class="card">
                        <div class="card-header" id="heading">
                        </div>
                        <div class="card-body" id="showHistory">
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