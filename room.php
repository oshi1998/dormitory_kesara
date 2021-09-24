<?php
session_start();

require_once('api/connect.php');

$sql = "SELECT * FROM roomtypes ORDER BY created DESC";
$stmt = $pdo->query($sql);
$roomtypes = $stmt->fetchAll();

$sql = "SELECT rooms.id,img,price,type,description FROM rooms,roomtypes WHERE rooms.type=roomtypes.id AND active='พร้อมใช้งาน' ORDER BY rooms.created DESC";
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
    #myModal .modal-dialog {
      -webkit-transform: translate(0, -50%);
      -o-transform: translate(0, -50%);
      transform: translate(0, -50%);
      top: 50%;
      margin: 0 auto;
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
            <h4>new arrivals</h4>
            <h2>sixteen products</h2>
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
              <?php foreach ($roomtypes as $type) { ?>
                <li data-filter=".<?= $type['id'] ?>"><?= $type['name'] ?></li>
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
                        <h4><?= $room['id'] ?></h4>
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