<?php

require_once('permission/access.php');
require_once('api/connect.php');

if (isset($_GET["id"]) && !empty($_GET["id"])) {

    function dateThai($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

    function convertAmountToLetter($number)
    {
        if (empty($number)) return "";
        $number = strval($number);
        $txtnum1 = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
        $txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
        $number = str_replace(",", "", $number);
        $number = str_replace(" ", "", $number);
        $number = str_replace("บาท", "", $number);
        $number = explode(".", $number);
        if (sizeof($number) > 2) {
            return '';
            exit;
        }
        $strlen = strlen($number[0]);
        $convert = '';
        for ($i = 0; $i < $strlen; $i++) {
            $n = substr($number[0], $i, 1);
            if ($n != 0) {
                if ($i == ($strlen - 1) && $n == 1) {
                    $convert .= 'เอ็ด';
                } elseif ($i == ($strlen - 2) && $n == 2) {
                    $convert .= 'ยี่';
                } elseif ($i == ($strlen - 2) && $n == 1) {
                    $convert .= '';
                } else {
                    $convert .= $txtnum1[$n];
                }
                $convert .= $txtnum2[$strlen - $i - 1];
            }
        }
        $convert .= 'บาท';
        if (sizeof($number) == 1) {
            $convert .= 'ถ้วน';
        } else {
            if ($number[1] == '0' || $number[1] == '00' || $number[1] == '') {
                $convert .= 'ถ้วน';
            } else {
                $number[1] = substr($number[1], 0, 2);
                $strlen = strlen($number[1]);
                for ($i = 0; $i < $strlen; $i++) {
                    $n = substr($number[1], $i, 1);
                    if ($n != 0) {
                        if ($i > 0 && $n == 1) {
                            $convert .= 'เอ็ด';
                        } elseif ($i == 0 && $n == 2) {
                            $convert .= 'ยี่';
                        } elseif ($i == 0 && $n == 1) {
                            $convert .= '';
                        } else {
                            $convert .= $txtnum1[$n];
                        }
                        $convert .= $i == 0 ? $txtnum2[1] : '';
                    }
                }
                $convert .= 'สตางค์';
            }
        }
        return $convert . PHP_EOL;
    }

    $np_id = $_GET["id"];

    //SQL ดึงข้อมูล Notice Payments
    $sql = "SELECT * FROM notice_payments,customers WHERE notice_payments.np_customer_username=customers.username AND np_id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$np_id]);
    $row = $stmt->fetchObject();

    //SQL ดึงข้อมูล Notice Payment Details
    $sql = "SELECT * FROM notice_payment_details WHERE npd_np_id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$np_id]);
    $npd = $stmt->fetchAll();
} else {
    header("location:notice_payment.php");
    exit;
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
    <title><?= $np_id ?></title>
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

    <div class="container border mt-3">
        <div class="row border-bottom">
            <div class="col-8 mt-3">
                <h1>หอพักเกศรานครสวรรค์</h1>
                <p>ที่อยู่: ที่อยู่ 116/6 ซอสวรรค์วิถี 65 หมู่ 1 จ.นครสวรรค์ อ.เมืองนครสวรรค์ ต.นครสวรรค์ตก 60000 <br>ติดต่อสอบถามโทร 086-4494774</p>
            </div>
            <div class="col-4 mt-4">
                <h3>ใบแจ้งหนี้/ใบเสร็จรับเงิน</h3>
                <p class="mt-3">เลขที่: <u><?= $np_id ?></u></p>
            </div>
        </div>

        <div class="row mt-3 border-bottom">
            <div class="col-9">
                <p>ผู้เช่าห้อง: <u><?= $row->firstname . " " . $row->lastname ?></u></p>

            </div>
            <div class="col-3">
                <p>ออกบิลเมื่อ: <u><?= dateThai($row->np_created) ?></u></p>
            </div>
            <div class="col-9">
                <p>หมายเลขห้อง: <u><?= $row->np_room_id ?></u></p>
            </div>
            <div class="col-3">
                <p>ประจำเดือน: <u><?= $row->np_month . " " . $row->np_year ?></u></p>
            </div>
        </div>

        <div class="row mt-3 p-3">
            <div class="col-12">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>รายการ</th>
                            <th>จำนวนเงิน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($npd as $item) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $item['npd_name'] ?></td>
                                <td><?= number_format($item['npd_cost'], 2) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>รวมทั้งสิ้น</th>
                            <th><u><?= convertAmountToLetter($row->np_cost) ?></u></td>
                            <th><u><?= number_format($row->np_cost, 2) ?></u></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="col-12 text-center">
                <p>กรุณาชำระเงินภายในวันที่ <?= $row->np_expired_date ?> ของเดือน หากเกินกำหนดจะถูกปรับวันละ <?= number_format($row->np_fine, 2) ?> บาท</p>
            </div>

            <div class="col-12 d-flex justify-content-between">
                <p>สถานะ: <u><?= $row->np_status ?></u></p>
                <p>รูปแบบการชำระเงิน: <u><?= ($row->np_pay == "") ? "ยังไม่ได้ชำระเงิน" : $row->np_pay ?></u></p>
                <p>ผู้จัดการ: <u><?= $row->np_manager_name ?></u></p>
            </div>
        </div>

    </div>

    <div class="container mt-3">
        <div id="manageZone">
            <button class="btn btn-success" onclick="print_np()">
                <i class="fas fa-print"></i>
                <span>พิมพ์ใบแจ้งหนี้/ใบเสร็จรับเงิน</span>
            </button>
        </div>
    </div>




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

    <script>
        function print_np() {
            $('#manageZone').hide();
            window.print();
            $('#manageZone').show();
        }
    </script>
</body>

</html>