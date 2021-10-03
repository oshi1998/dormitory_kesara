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
    <title>เข้าสู่ระบบ | DORMITORY KESARA</title>


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
                        <h4>เข้าสู่ระบบ</h4>
                        <h2>เข้าสู่ระบบเพื่อจองห้องพัก</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="find-us">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-4 col-12">
                    <form id="loginForm">
                        <div class="form-group" id="heading">
                            <strong>ตรวจสอบสิทธิ์การใช้งาน</strong>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้งาน" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">เข้าสู่ระบบ</button>
                        </div>
                        <div class="form-group">
                            <a href="register.php">ยังไม่มีบัญชีผู้ใช้งาน?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once('layouts/footer.php'); ?>


    <script src="functions/login.js"></script>
</body>

</html>