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
  <title>หน้าหลัก | DORMITORY KESARA</title>


  <?php require_once('layouts/head.php'); ?>

</head>

<body>

  <!-- ***** Preloader Start ***** -->
  <?php require_once('layouts/preloader.php'); ?>
  <!-- ***** Preloader End ***** -->

  <!-- Header -->
  <?php require_once('layouts/menu.php'); ?>

  <!-- Page Content -->
  <!-- Banner Starts Here -->
  <div class="banner header-text">
    <div class="owl-banner owl-carousel">
      <div class="banner-item-01">
        <div class="text-content">
          <h4>Best Offer</h4>
          <h2>New Arrivals On Sale</h2>
        </div>
      </div>
      <div class="banner-item-02">
        <div class="text-content">
          <h4>Flash Deals</h4>
          <h2>Get your best products</h2>
        </div>
      </div>
      <div class="banner-item-03">
        <div class="text-content">
          <h4>Last Minute</h4>
          <h2>Grab last minute deals</h2>
        </div>
      </div>
    </div>
  </div>
  <!-- Banner Ends Here -->

  <div class="best-features">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>เกี่ยวกับเรา</h2>
          </div>
        </div>
        <div class="col-md-6">
          <div class="left-content">
            <h4>Looking for the best products?</h4>
            <p><a rel="nofollow" href="https://templatemo.com/tm-546-sixteen-clothing" target="_parent">This template</a> is free to use for your business websites. However, you have no permission to redistribute the downloadable ZIP file on any template collection website. <a rel="nofollow" href="https://templatemo.com/contact">Contact us</a> for more info.</p>
            <ul class="featured-list">
              <li><a href="#">Lorem ipsum dolor sit amet</a></li>
              <li><a href="#">Consectetur an adipisicing elit</a></li>
              <li><a href="#">It aquecorporis nulla aspernatur</a></li>
              <li><a href="#">Corporis, omnis doloremque</a></li>
              <li><a href="#">Non cum id reprehenderit</a></li>
            </ul>
            <a href="about.html" class="filled-button">Read More</a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="right-image">
            <img src="assets/images/feature-image.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once('layouts/footer.php'); ?>

</body>

</html>