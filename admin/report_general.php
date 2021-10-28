<?php require_once('permission/access.php') ?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รายงานทั่วไป | ระบบจัดการข้อมูลหลังบ้าน DORMITORY KESARA</title>
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
                            <h1 class="m-0">รายงานทั่วไป</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">แดชบอร์ด</a></li>
                                <li class="breadcrumb-item active">รายงานทั่วไป</li>
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
                        <ul>
                            <li>
                                <a target="_blank" href="show_report.php?report=allcus">รายชื่อลูกค้าในระบบทั้งหมด</a>
                            </li>
                            <li>
                                <a target="_blank" href="show_report.php?report=allroom">รายชื่อห้องพักทั้งหมด</a>
                            </li>
                            <li>
                                <a target="_blank" href="show_report.php?report=alldailyroom">รายชื่อห้องพักรายวันทั้งหมด</a>
                            </li>
                            <li>
                                <a target="_blank" href="show_report.php?report=allmonthlyroom">รายชื่อห้องพักรายเดือนทั้งหมด</a>
                            </li>
                            <li>
                                <a target="_blank" href="show_report.php?report=allrepair">รายการแจ้งซ่อมทั้งหมด</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.row -->
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
</body>

</html>