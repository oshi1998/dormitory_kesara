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
  <title>ติดต่อเรา | DORMITORY KESARA</title>


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
            <h4>ติดต่อเรา</h4>
            <h2>ข้อมูลการติดต่อเรา</h2>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="find-us">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>แผนที่หอพักเกศรา</h2>
          </div>
        </div>
        <div class="col-md-8">
          <!-- How to change your own map point
	1. Go to Google Maps
	2. Click on your location point
	3. Click "Share" and choose "Embed map" tab
	4. Copy only URL and paste it within the src="" field below
-->
          <div id="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d679.0766263505526!2d100.10557285229697!3d15.674914228691609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e04f22c1577f47%3A0x6eb66ed9af98669f!2z4Lir4Lit4Lie4Lix4LiB4LmA4LiB4Lio4Lij4Liy!5e0!3m2!1sen!2sth!4v1631624617192!5m2!1sen!2sth" width="100%" height="330px" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div>
        </div>
        <div class="col-md-4">
          <div class="left-content">
            <h4>เกี่ยวกับหอพักของเรา</h4>
            <p>ห้องพักพร้อมเฟอร์นิเจอร์ มีห้องน้ำในห้องพัก มีทั้งห้องแอร์และพัดลมหอพักใกล้ตัวเมืองนครสวรรค์
              และตลาดศรีนครที่เป็นตลาดขนาดใหญ่และมีของกินมากมายอยู่ใกล้เคียงกับหอพัก<br><br>
              ที่อยู่ 116/6 ซอสวรรค์วิถี 65 หมู่ 1 จ.นครสวรรค์ <br>อ.เมืองนครสวรรค์ ต.นครสวรรค์ตก&nbsp;60000</p>
            <ul class="social-icons">
              <li>
                <a target="_blank" href="https://www.facebook.com/%E0%B8%AB%E0%B8%AD%E0%B8%9E%E0%B8%B1%E0%B8%81%E0%B9%80%E0%B8%81%E0%B8%A8%E0%B8%A3%E0%B8%B2-101937718539789">
                  <i class="fa fa-facebook"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once('layouts/footer.php'); ?>


</body>

</html>