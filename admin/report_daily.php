<?php
require_once('permission/access.php');
require_once('api/connect.php');

$today = date("Y-m-d");

if (isset($_POST["start"]) && isset($_POST["end"])) {
    $start = $_POST["start"];
    $end = $_POST["end"];

    $sql = "SELECT daily_books.id,daily_room_id,firstname,lastname,address,phone_number,email,daterange,cost,daily_books.status FROM daily_books,customers WHERE daily_books.customer_username=customers.username AND check_in BETWEEN '$start' AND '$end'";
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll();

    $date =  $start . " ถึง " . $end;
} else {
    $sql = "SELECT daily_books.id,daily_room_id,firstname,lastname,address,phone_number,email,daterange,cost,daily_books.status FROM daily_books,customers WHERE daily_books.customer_username=customers.username AND daily_books.status='อยู่ระหว่างการเช็คอิน'";
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll();

    $date = $today;
}



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
    <title>รายงานห้องรายวัน | ระบบจัดการข้อมูลหลังบ้าน DORMITORY KESARA</title>
    <!-- Sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
                            <h1 class="m-0">รายงานห้องรายวัน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">แดชบอร์ด</a></li>
                                <li class="breadcrumb-item active">รายงานห้องรายวัน</li>
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
                    
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    ค้นหาการใช้งานห้องรายวันตามช่วงวันที่
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label>วันที่เริ่ม</label>
                                            <input type="date" class="form-control" name="start" required>
                                        </div>
                                        <div class="form-group">
                                            <label>วันที่สิ้นสุด</label>
                                            <input type="date" class="form-control" name="end" required>
                                        </div>
                                        <div class="form-group float-right">
                                            <button type="submit" class="btn btn-success">ค้นหา</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between">
                                        ข้อมูลการใช้งานห้องรายวัน <?= $date ?>
                                        <?php if (isset($_POST['start']) && isset($_POST['end'])) : ?>
                                            <a target="_blank" href="show_report.php?report=usedailyroom&start=<?= $start ?>&end=<?= $end ?>">
                                                <i class="fas fa-print"></i>
                                                <span>พิมพ์รายงาน</span>
                                            </a>
                                        <?php else : ?>
                                            <a target="_blank" href="show_report.php?report=usedailyroom">
                                                <i class="fas fa-print"></i>
                                                <span>พิมพ์รายงาน</span>
                                            </a>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>รหัส</th>
                                                    <th>เลขห้อง</th>
                                                    <th>ชื่อลูกค้า</th>
                                                    <th>ข้อมูลติดต่อ</th>
                                                    <th>วันที่เช็คอิน-เช็คเอาท์</th>
                                                    <th>ค่าที่พัก</th>
                                                    <th>สถานะ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data as $row) { ?>
                                                    <tr>
                                                        <td><?= $row['id'] ?></td>
                                                        <td><?= $row['daily_room_id'] ?></td>
                                                        <td><?= $row['firstname'] . " " . $row['lastname'] ?></td>
                                                        <td>
                                                            ที่อยู่: <?= $row['address'] ?> <br>
                                                            เบอร์โทร: <?= $row['phone_number'] ?> <br>
                                                            อีเมล: <?= $row['email'] ?>
                                                        </td>
                                                        <td><?= $row['daterange'] ?></td>
                                                        <td><?= $row['cost'] ?></td>
                                                        <td><?= $row['status'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
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
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    <script>
        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    </script>
</body>

</html>