<?php
require_once('permission/access.php');
require_once('api/connect.php');

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

if (isset($_POST["month"]) && !empty($_POST["month"]) && isset($_POST["year"]) && !empty($_POST["year"])) {
    $current_month = $_POST["month"];
    $current_year = $_POST["year"];
} else {
    $current_month = monthThai(date("Y-m-d"));
    $current_year = yearThai(date("Y-m-d"));
}

//SQL ดึงปีที่น้อยที่สุดในตาราง Notice Payments
$sql = "SELECT MIN(np_year) as min_year  FROM notice_payments GROUP BY np_year";
$stmt = $pdo->query($sql);
$row = $stmt->fetchObject();

if (empty($row)) {
    $earliest_year = $current_year;
} else {
    $earliest_year = $row->min_year;
}

//SQL ดึงข้อมูลแจ้งชำระเงินเดือนและปีปัจจุบัน
$sql = "SELECT * FROM notice_payments,customers WHERE notice_payments.np_customer_username=customers.username AND np_month=:month AND np_year=:year ORDER BY np_created DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'month' => $current_month,
    'year' => $current_year
]);
$data = $stmt->fetchAll();

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
    <title>รายงานห้องรายเดือน | ระบบจัดการข้อมูลหลังบ้าน DORMITORY KESARA</title>
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
                            <h1 class="m-0">รายงานห้องรายเดือน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">แดชบอร์ด</a></li>
                                <li class="breadcrumb-item active">รายงานห้องรายเดือน</li>
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
                                    <h3 class="card-title">
                                        ค้นหาการใช้งานห้องรายเดือน
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form class="form-inline mt-2" id="findNPForm" method="post">
                                        <div class="form-group mb-2">
                                            <label>เดือน</label>
                                            <select class="form-control mx-sm-3" name="month">
                                                <option value="มกราคม">มกราคม</option>
                                                <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                                                <option value="มีนาคม">มีนาคม</option>
                                                <option value="เมษายน">เมษายน</option>
                                                <option value="พฤษภาคม">พฤษภาคม</option>
                                                <option value="มิถุนายน">มิถุนายน</option>
                                                <option value="กรกฎาคม">กรกฎาคม</option>
                                                <option value="สิงหาคม">สิงหาคม</option>
                                                <option value="กันยายน">กันยายน</option>
                                                <option value="ตุลาคม">ตุลาคม</option>
                                                <option value="พฤศจิกายน">พฤศจิกายน</option>
                                                <option value="ธันวาคม">ธันวาคม</option>
                                            </select>
                                        </div>
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label>ปี</label>
                                            <select class="form-control mx-sm-3" name="year">
                                                <?php foreach (range($current_year, $earliest_year) as $year) { ?>
                                                    <option value="<?= $year ?>"><?= $year ?></option>
                                                <?php } ?>
                                            </select>

                                            <br>
                                            <button type="submit" class="btn btn-primary">ค้นหา</button>
                                        </div>
                                    </form>

                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between">
                                        ข้อมูลการใช้งานห้องรายเดือน <?= $current_month ?> ปี <?= $current_year ?>
                                        <a target="_blank" href="show_report.php?report=usemonthlyroom&month=<?= $current_month ?>&year=<?= $current_year ?>">
                                            <i class="fas fa-print"></i>
                                            <span>พิมพ์รายงาน</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="dataTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>หมายเลขห้อง</th>
                                                <th>ผู้เช่า</th>
                                                <th>ค่าห้อง</th>
                                                <th>ค่าน้ำ</th>
                                                <th>ค่าไฟ</th>
                                                <th>รวมทั้งหมด</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data as $row) { ?>
                                                <?php
                                                $sql = "SELECT * FROM notice_payment_details WHERE npd_np_id='$row[np_id]'";
                                                $stmt = $pdo->query($sql);
                                                $npd = $stmt->fetchAll();
                                                ?>
                                                <tr>
                                                    <td><?= $row['np_room_id'] ?></td>
                                                    <td><?= $row['firstname'] . " " . $row['lastname'] ?></td>
                                                    <?php foreach ($npd as $item) { ?>
                                                        <td><?= $item['npd_cost'] ?></td>
                                                    <?php } ?>
                                                    <td><?= number_format($row['np_cost'], 2) ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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