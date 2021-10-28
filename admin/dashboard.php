<?php
require_once('permission/access.php');
require_once('api/connect.php');

//รายวัน
$sql = "SELECT COUNT(*) as rent_room FROM daily_books WHERE status='อยู่ระหว่างการเช็คอิน'";
$stmt = $pdo->query($sql);
$obj1 = $stmt->fetchObject();

$sql = "SELECT COUNT(*) as free_room FROM daily_rooms WHERE daily_rooms.id NOT IN (SELECT daily_room_id FROM daily_books WHERE status='อยู่ระหว่างการเช็คอิน')";
$stmt = $pdo->query($sql);
$obj2 = $stmt->fetchObject();

//รายเดือน
function monthThai($strDate)
{
    $strMonth = date("n", strtotime($strDate));
    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strMonthThai";
}

function yearThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    return "$strYear";
}

$current_month = monthThai(date("Y-m-d"));
$current_year = yearThai(date("Y-m-d"));

$sql = "SELECT COUNT(*) as rent_room FROM monthly_books WHERE status='อยู่ระหว่างการเช่าห้อง'";
$stmt = $pdo->query($sql);
$obj3 = $stmt->fetchObject();

$sql = "SELECT COUNT(*) as free_room FROM monthly_rooms WHERE monthly_rooms.id NOT IN (SELECT monthly_room_id FROM monthly_books WHERE status='อยู่ระหว่างการเช่าห้อง')";
$stmt = $pdo->query($sql);
$obj4 = $stmt->fetchObject();

?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>แดชบอร์ด | ระบบจัดการข้อมูลหลังบ้าน DORMITORY KESARA</title>
    <!-- Sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini" onload="count()">
    <div class="wrapper">

        <!-- Include Navigator file -->
        <?php include_once('layouts/navigator.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">ยินดีต้อนรับ <strong class="text-red"><?= $_SESSION['ADMIN_USERNAME']; ?></strong> สู่ระบบจัดการข้อมูลหลังบ้าน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">แดชบอร์ด</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 id="c1"></h3>
                                    <p>ผู้ดูแลระบบ</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="admin.php" class="small-box-footer">จัดการข้อมูล <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 id="c2"></h3>
                                    <p>ลูกค้า</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="customer.php" class="small-box-footer">จัดการข้อมูล <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3 id="c3"></h3>
                                    <p>ห้องพักรายวัน</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="daily_room.php" class="small-box-footer">จัดการข้อมูล <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3 id="c4"></h3>
                                    <p>ห้องพักรายเดือน</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="monthly_room.php" class="small-box-footer">จัดการข้อมูล <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->

                    <hr>

                    <div class="row">

                        <div class="col-12">
                            <h1 class="m-0">รายงานห้องรายวัน ประจำวันที่ <?= date("d-m-Y"); ?></h1>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?= $obj1->rent_room ?> ห้อง</h3>
                                    <p>กำลังใช้งาน</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= $obj2->free_room ?> ห้อง</h3>
                                    <p>ว่าง</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-12">
                            <h1 class="m-0">รายงานห้องรายเดือน ประจำเดือน <?= $current_month ?> ปี <?= $current_year ?></h1>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?= $obj3->rent_room ?> ห้อง</h3>
                                    <p>กำลังใช้งาน</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= $obj4->free_room ?> ห้อง</h3>
                                    <p>ว่าง</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Include footer file -->
        <?php include_once('layouts/footer.php') ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    <script src="functions/dashboard.js"></script>
</body>

</html>