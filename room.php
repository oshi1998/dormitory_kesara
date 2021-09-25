<?php
session_start();

require_once('api/connect.php');

$sql = "SELECT type FROM roomtypes GROUP BY type";
$stmt = $pdo->query($sql);
$types = $stmt->fetchAll();

$sql = "SELECT * FROM roomtypes ORDER BY created DESC";
$stmt = $pdo->query($sql);
$rooms = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>ห้องพัก | DORMITORY KESARA</title>


  <?php require_once('layouts/head.php'); ?>

  <style>
    .modal {
      display: none;
      /* Hidden by default */
      position: fixed;
      /* Stay in place front is invalid - may break your css so removed */
      padding-top: 100px;
      /* Location of the box - don't know what this does?  If it is to move your modal down by 100px, then just change top below to 100px and remove this*/
      left: 0;
      right: 0;
      /* Full width (left and right 0) */
      top: 0;
      bottom: 0;
      /* Full height top and bottom 0 */
      overflow: auto;
      /* Enable scroll if needed */
      background-color: rgb(0, 0, 0);
      /* Fallback color */
      background-color: rgba(0, 0, 0, 0.4);
      /* Black w/ opacity */
      z-index: 9999;
      /* Sit on top - higher than any other z-index in your site*/
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
  <div class="page-heading products-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="text-content">
            <h4>ห้องพัก</h4>
            <h2>ประเภทห้องพัก และราคา</h2>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="products">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="filters">
            <ul>
              <li class="active" data-filter="*">ทั้งหมด</li>
              <?php foreach ($types as $type) { ?>
                <li data-filter=".<?= $type['type'] ?>"><?= $type['type'] ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <div class="col-md-12">
          <div class="filters-content">
            <div class="row grid">
              <?php foreach ($rooms as $room) { ?>
                <div class="col-lg-4 col-md-4 all <?= $room['type'] ?>">
                  <div class="product-item">
                    <a href="javascript:void(0)" onclick="viewDetail('<?= $room['id'] ?>')">
                      <img src="admin/dist/img/room/<?= $room['img'] ?>">
                    </a>
                    <div class="down-content">
                      <a href="javascript:void(0)" onclick="viewDetail('<?= $room['id'] ?>')">
                        <h4><?= $room['name'] ?></h4>
                      </a>
                      <h6><?= number_format($room['price']) ?> บาท</h6>
                      <p><?= $room['description'] ?></p>
                      <ul class="stars">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>
                        <a href="javascript:void(0)" onclick="viewDetail('<?= $room['id'] ?>')">เพิ่มเติม</a>
                      </span>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
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


  <script src="functions/room.js"></script>
</body>

</html>