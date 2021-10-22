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

function dateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

$current_month = monthThai(date("Y-m-d"));
$current_year = yearThai(date("Y-m-d"));


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


//SQL ดึงห้องพักรายเดือนที่กำลังพักอยู่
$sql = "SELECT monthly_room_id FROM monthly_books WHERE status=:status";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'status' => "อยู่ระหว่างการเช่าห้อง"
]);
$rooms = $stmt->fetchAll();

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
    <title>ข้อมูลแจ้งชำระเงินห้องรายเดือน | ระบบจัดการข้อมูลหลังบ้าน DORMITORY KESARA</title>
    <!-- Sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
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
                            <h1 class="m-0">ข้อมูลแจ้งชำระเงินห้องรายเดือน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">แดชบอร์ด</a></li>
                                <li class="breadcrumb-item active">ข้อมูลแจ้งชำระเงินห้องรายเดือน</li>
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        ค้นหาประวัติแจ้งชำระเงินห้องรายเดือน
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form class="form-inline mt-2" id="findNPForm">
                                        <div class="form-group mb-2">
                                            <label>เดือน</label>
                                            <select class="form-control mx-sm-3" name="month">
                                                <option value="" selected disabled>--- เลือกเดือน ---</option>
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
                                                <option value="" selected disabled>--- เลือกปี ---</option>
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

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    ข้อมูลแจ้งชำระเงินห้องรายเดือน <?= $current_month ?> ปี <?= $current_year ?>
                                    <button type="button" class="btn btn-outline-info float-right" data-toggle="modal" data-target="#newBillModal">+ สร้างบิลใหม่</button>
                                </div>
                                <div class="card-body">
                                    <table id="dataTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>วันที่ออกบิล</th>
                                                <th>รหัสบิล</th>
                                                <th>ผู้เช่า</th>
                                                <th>หมายเลขห้อง</th>
                                                <th>รูปแบบการชำระเงิน</th>
                                                <th>สถานะ</th>
                                                <th>รวมทั้งหมด</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data as $row) { ?>
                                                <tr>
                                                    <td><?= dateThai($row['np_created']) ?></td>
                                                    <td><?= $row['np_id'] ?></td>
                                                    <td><?= $row['firstname'] . " " . $row['lastname'] ?></td>
                                                    <td><?= $row['np_room_id'] ?></td>
                                                    <td>
                                                        <?php if ($row['np_pay'] == "ชำระด้วยเงินสด") : ?>
                                                            <span class="badge badge-info"><?= $row['np_pay'] ?></span>
                                                        <?php elseif ($row['np_pay'] == "ชำระออนไลน์") : ?>
                                                            <span class="badge badge-warning"><?= $row['np_pay'] ?></span>
                                                            <hr>
                                                            <p>บัญชีผู้รับโอน: <?= $row['np_receive_acc'] . " " . $row['np_receive_bank'] ?></p>
                                                            <p>ชื่อบัญชีผู้รับโอน: <?= $row['np_receive_owner'] ?></p>
                                                            <hr>
                                                            <p>บัญชีผู้โอน: <?= $row['np_transfer_acc'] . " " . $row['np_transfer_bank'] ?></p>
                                                            <p>ชือบัญชีผู้โอน: <?= $row['np_transfer_owner'] ?></p>
                                                            <p>วันเวลาที่โอน: <?= $row['np_transfer_datetime'] ?></p>
                                                            <p>สลิป: <button class="btn btn-primary" onclick="viewSlip('<?= $row['np_id'] ?>','<?= $row['np_slip'] ?>')">ดูสลิป</button></p>
                                                        <?php endif ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row['np_status'] == "รอชำระเงิน" || $row['np_status'] == "รอชำระเงิน (เงินสด)") : ?>
                                                            <span class="badge badge-danger"><?= $row['np_status'] ?></span>
                                                        <?php elseif ($row['np_status'] == "รอตรวจสอบ") : ?>
                                                            <span class="badge badge-primary"><?= $row['np_status'] ?></span>
                                                        <?php elseif ($row['np_status'] == "สำเร็จ") :  ?>
                                                            <span class="badge badge-success"><?= $row['np_status'] ?></span>
                                                        <?php elseif ($row['np_status'] == "ปฏิเสธ") : ?>
                                                            <span class="badge badge-danger"><?= $row['np_status'] ?></span>
                                                        <?php endif ?>
                                                    </td>
                                                    <td><?= number_format($row['np_cost'], 2) ?></td>
                                                    <td>
                                                        <a target="_blank" href="np_info.php?id=<?= $row['np_id'] ?>" class="btn btn-info">
                                                            <i class="fas fa-info"></i>
                                                            <span>รายละเอียด</span>
                                                        </a>
                                                        <?php if ($row['np_status'] == "รอชำระเงิน") : ?>
                                                            <button class="btn btn-danger" onclick="deleteData('<?= $row['np_id'] ?>')">
                                                                <i class="fas fa-trash"></i>
                                                                <span>ลบ</span>
                                                            </button>
                                                        <?php elseif ($row['np_status'] == "รอตรวจสอบ" || $row['np_status'] == "รอชำระเงิน (เงินสด)") : ?>
                                                            <button class="btn btn-success" onclick="acceptPay('<?= $row['np_id'] ?>')">
                                                                <i class="fas fa-check-circle"></i>
                                                                <span>การชำระเงินสำเร็จ</span>
                                                            </button>
                                                            <button class="btn btn-danger" onclick="refusePay('<?= $row['np_id'] ?>')">
                                                                <i class="fas fa-window-close"></i>
                                                                <span>ปฏิเสธการชำระเงิน</span>
                                                            </button>
                                                        <?php endif ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Modal -->
        <div class="modal fade" id="newBillModal" tabindex="-1" role="dialog" aria-labelledby="newBillModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newBillModalLabel">สร้างบิลเรียกชำระเงินใหม่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-inline mt-2" id="newBillForm">
                            <div class="form-group mb-2">
                                <label>เดือน</label>
                                <select class="form-control mx-sm-3" name="month">
                                    <option value="<?= $current_month ?>"><?= $current_month ?></option>
                                </select>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label>ปี</label>
                                <select class="form-control mx-sm-3" name="year">
                                    <option value="<?= $current_year ?>"><?= $current_year ?></option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>ห้องพักรายเดือน</label>
                                <select class="form-control mx-sm-3" name="room_id" onchange="getRoomDetail(event.target.value)">
                                    <option value="" selected disabled>--- เลือกห้อง ---</option>
                                    <?php foreach ($rooms as $room) { ?>
                                        <option value="<?= $room['monthly_room_id'] ?>"><?= $room['monthly_room_id'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>ชื่อผู้เช่า</label>
                                <input type="text" class="form-control mx-sm-3" name="customer_username" id="customer_username" hidden>
                                <input type="text" class="form-control mx-sm-3" id="customer_name" readonly>
                            </div>
                            <div class="form-group mb-2">
                                <label>ชื่อผู้จัดการ</label>
                                <input type="text" class="form-control mx-sm-3" name="manager_name" value="<?= $_SESSION['ADMIN_FIRSTNAME'] . " " . $_SESSION['ADMIN_LASTNAME'] ?>" readonly>
                            </div>
                            <div class="form-group mb-2">
                                <label>ชำระเงินภายในวันที่</label>
                                <select class="form-control mx-sm-3" name="expired_date">
                                    <option value="" selected disabled>--- เลือกวัน ---</option>
                                    <?php $start = 1; ?>
                                    <?php foreach (range($start, 31) as $day) { ?>
                                        <option value="<?= $day ?>"><?= $day . " ของเดือน" ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>ค่าปรับวันละ</label>
                                <input type="number" class="form-control mx-sm-3" name="fine">
                            </div>

                            <hr>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>รายการ</th>
                                            <th>จำนวนเงิน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="npd[0][name]" value="ค่าเช่าห้อง" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="npd[0][cost]" id="npd_room_cost" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="npd[1][name]" value="ค่าน้ำ">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="npd[1][cost]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="npd[2][name]" value="ค่าไฟ">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="npd[2][cost]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="npd[3][name]" placeholder="ชื่อรายการ">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="npd[3][cost]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="npd[4][name]" placeholder="ชื่อรายการ">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="npd[4][cost]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="npd[5][name]" placeholder="ชื่อรายการ">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="npd[5][cost]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="npd[6][name]" placeholder="ชื่อรายการ">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="npd[6][cost]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="npd[7][name]" placeholder="ชื่อรายการ">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="npd[7][cost]">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="create()">ตกลง</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
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

        <!-- Include footer file -->
        <?php include_once('layouts/footer.php') ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
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

    <!-- Notice Payment Script -->
    <script src="functions/notice_payment.js"></script>
</body>

</html>