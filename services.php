<?php

session_start();

require_once('api/connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

  <title>บริการ | DORMITORY KESARA</title>


  <?php require_once('layouts/head.php'); ?>

</head>

<body>

  <!-- ***** Preloader Start ***** -->
  <?php require_once('layouts/preloader.php'); ?>
  <!-- ***** Preloader End ***** -->

  <!-- Header -->
  <?php require_once('layouts/menu.php'); ?>

  <!-- Page Content -->
  <div class="page-heading products-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="text-content">
            <h4>บริการของเรา</h4>
            <h2>ข้อมูลบริการของเรา</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="products">

    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="services__item">
            <img src="assets/images/101.png" alt="">
            <h4>Free Wi-Fi</h4>
            <p>หอพักมีบริการ ฟรีอินเทอร์เน็ตวายฟายให้กับลูกค้าในหอพักทุกท่านได้ใช้งานฟรี</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="services__item">
            <img src="assets/images/102.png" alt="">
            <h4>TV HD</h4>
            <p>มีทีวี Full HD ให้บริการและยังติดกล่องจารดาวเทียมให้ด้วย</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="services__item">
            <img src="assets/images/103.png" alt="">
            <h4>Resraurant</h4>
            <p>หอพักนั้นค่อนข้างอยู่ใกล้กับตัวเมืองและร้านอาหารแล้วยังมีตลาดขนาดใหญ่อยู่ใกล้เคียงกับหอพักของเรา</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="services__item">
            <img src="assets/images/104.png" alt="">
            <h4>Washing Machine</h4>
            <p>มีบริการเครื่องซักผ้าหยอดเหรีญมากมายให้ลูกค้าไม่ว่าจะเป็นในหอพักและข้างนอกหอพัก</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="services__item">
            <img src="assets/images/107.png" alt="">
            <h4>Free Parking</h4>
            <p>ทางหอพักของเรานั้นมีบริการที่จอดรถฟรีให้กับลูกค้าที่มีรถยนต์และรถจักรยานยนต์</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="services__item">
            <img src="assets/images/106.png" alt="">
            <h4>Key card</h4>
            <p>หอพักเกศรามีการใช้ระบบคีย์การ์ดในการเข้าออกหอพักจึงทำให้บุคคลภายนอกไม่สามารถเข้ามาในหอพักได้ง่ายและยังปลอดภัยต่อบุคคลภายในหอพักอีกด้วย.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once('layouts/footer.php'); ?>


</body>

</html>