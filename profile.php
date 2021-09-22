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
    <title>ข้อมูลส่วนตัว | DORMITORY KESARA</title>


    <?php require_once('layouts/head.php'); ?>
</head>

<body onload="getCustomerData('<?= $_SESSION['CUSTOMER_ID'] ?>')">

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
                        <h4>ข้อมูลส่วนตัว</h4>
                        <h2>จัดการข้อมูลส่วนตัว</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="find-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-12">
                    <div class="card">
                        <div class="card-header">
                            ข้อมูลส่วนตัว
                        </div>
                        <div class="card-body" id="myprofile">
                        </div>
                    </div>

                    <br><br>
                    <form id="changePasswordForm">
                        <div class="form-group text-center" id="heading2">
                            <strong>เปลี่ยนรหัสผ่าน</strong>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="old_password" id="old_password" placeholder="รหัสผ่านเดิม" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="รหัสผ่านใหม่" required>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success">บันทึกการเปลี่ยนแปลง</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-7 col-12">
                    <form id="updateProfileForm">
                        <div class="form-group text-center" id="heading">
                            <strong>แก้ไขข้อมูลส่วนตัว</strong>
                        </div>
                        <div class="form-group">
                            <label>ชื่อจริง</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" onchange="checkFirstname(event.target.value)" placeholder="ชื่อจริง" required>
                        </div>
                        <div class="form-group">
                            <label>นามสกุล</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="นามสกุล" required>
                        </div>
                        <div class="form-group">
                            <label>เพศ</label>
                            <select class="form-control" name="gender" id="gender">
                                <option value="ชาย">ชาย</option>
                                <option value="หญิง">หญิง</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>เบอร์โทร</label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number" minlength="10" placeholder="เบอร์โทร (มากกว่า 1 เบอร์ได้)" required>
                        </div>
                        <div class="form-group">
                            <label>ที่อยู่</label>
                            <textarea class="form-control" name="address" id="address" placeholder="ที่อยู่ (ไม่บังคับ)"></textarea>
                        </div>
                        <div class="form-group">
                            <label>อีเมล</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="อีเมล" onchange="checkEmail(event.target.value)" required>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success">บันทึกการเปลี่ยนแปลง</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once('layouts/footer.php'); ?>


    <script src="functions/profile.js"></script>
</body>

</html>