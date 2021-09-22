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
    <title>ลงทะเบียน | DORMITORY KESARA</title>


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
                        <h4>ลงทะเบียน</h4>
                        <h2>ลงทะเบียน เพื่อใช้งานเว็บไซต์ของเรา</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="find-us">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-4 col-12">
                    <form id="registerForm">
                        <div class="form-group" id="heading">
                            <strong>แบบฟอร์มลงทะเบียน</strong>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="firstname" id="inputFirstname" placeholder="ชื่อจริง" onchange="checkFirstname(event.target.value)" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="lastname" placeholder="นามสกุล" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="gender" required>
                                <option value="" selected disabled>--- เลือกเพศ ---</option>
                                <option value="ชาย">ชาย</option>
                                <option value="หญิง">หญิง</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="id_card" id="inputIdCard" minlength="13" maxlength="13" placeholder="เลขบัตรประจำตัวประชาชน (สำหรับเข้าสู่ระบบ)" onchange="checkIdCard(event.target.value)">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone_number" minlength="10" placeholder="เบอร์โทร (มากกว่า 1 เบอร์ได้)" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="address" placeholder="ที่อยู่ (ไม่บังคับ)"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="inputEmail" placeholder="อีเมล" onchange="checkEmail(event.target.value)" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">ลงทะเบียน</button>
                        </div>
                        <div class="form-group">
                            <a href="login.php">มีบัญชีผู้ใช้งานอยู่แล้ว?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once('layouts/footer.php'); ?>

    <script src="functions/register.js"></script>
</body>

</html>