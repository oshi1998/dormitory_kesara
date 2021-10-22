<?php

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
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
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
            <button class="btn btn-danger" onclick="window.history.back()">
                <i class="fas fa-arrow-left"></i>
                <span>ออก</span>
            </button>
            <button class="btn btn-success" onclick="print_np()">
                <i class="fas fa-print"></i>
                <span>พิมพ์ใบแจ้งหนี้/ใบเสร็จรับเงิน</span>
            </button>
        </div>

        <?php if ($row->np_status == "รอชำระเงิน") : ?>
            <div class="card mt-5">
                <div class="card-header">
                    แบบฟอร์มชำระค่าห้อง
                </div>
                <div class="card-body">
                    <form id="payForm">
                        <input type="text" class="form-group" name="id" value="<?= $np_id ?>" readonly hidden>
                        <div class="form-group">
                            <label>เลือกรูปแบบการชำระเงิน</label>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio1" name="pay" value="ชำระด้วยเงินสด" onchange="choosePay(event.target.value)">
                                <label for="customRadio1" class="custom-control-label">ชำระด้วยเงินสด (ชำระกับเจ้าของหอด้วยตัวเอง)</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio2" name="pay" value="ชำระออนไลน์" onchange="choosePay(event.target.value)">
                                <label for="customRadio2" class="custom-control-label">ชำระออนไลน์</label>
                            </div>
                        </div>
                    </form>

                    <div class="float-right">
                        <button type="button" class="btn btn-success" onclick="submit()">ตกลง</button>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>




    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="admin/dist/js/adminlte.min.js"></script>

    <script>
        function print_np() {
            $('#manageZone').hide();
            window.print();
            $('#manageZone').show();
        }

        function choosePay(value) {
            if (value == "ชำระด้วยเงินสด") {
                $('#payOnline').remove();
            } else if (value == "ชำระออนไลน์") {

                $('#submitBtn').remove();

                $.ajax({
                    method: "get",
                    url: "api/bank/read.php"
                }).done(function(res) {
                    let form_html =
                        `
                        <div id="payOnline">
                            <div class="table-responsive">
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>ภาพ</th>
                                            <th>ธนาคาร</th>
                                            <th>เลือก</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                `;

                    res.data.forEach(element => {
                        form_html +=
                            `
                                <tr>
                                    <td style="width:20%">
                                        <img width="100px" height="100px" src="admin/dist/img/bank/${element['img']}">
                                    </td>
                                    <td>${element['name']}</td>
                                    <td>
                                        <input class="form-check-input" type="radio" name="bankRadio" onclick="checkRadioBank('${element['id']}')">
                                    </td>
                                </tr>
                                `;
                    });

                    form_html +=
                        `
                                        </tbody>
                                    </table>
                                </div>
                            <div class="form-group">
                                <label>ธนาคารผู้รับ</label>
                                <input type="text" class="form-control" name="receive_bank" id="receive_bank" readonly>
                            </div>
                            <div class="form-group">
                                <label>เลขบัญชีผู้รับ</label>
                                <input type="text" class="form-control" name="receive_account_number" id="receive_account_number" readonly>
                            </div>
                            <div class="form-group">
                                <label>ชื่อบัญชีผู้รับ</label>
                                <input type="text" class="form-control" name="receive_owner" id="receive_owner" readonly>
                            </div>
                            <div class="form-group">
                                <label>ธนาคารผู้โอน</label>
                                <select class="form-control" name="transfer_bank">
                                    <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                                    <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                                    <option value="ธนาคารกรุงไทย">ธนาคารกรุงไทย</option>
                                    <option value="ธนาคารกรุงเทพ">ธนาคารกรุงเทพ</option>
                                    <option value="ธนาคารกรุงศรีอยุธยา">ธนาคารกรุงศรีอยุธยา</option>
                                    <option value="ธนาคารออมสิน">ธนาคารออมสิน</option>
                                    <option value="ธนาคารทหารไทย">ธนาคารทหารไทย</option>
                                    <option value="ธนาคารธนชาต">ธนาคารธนชาต</option>
                                    <option value="ธนาคารธกส">ธนาคารธกส</option>
                                    <option value="ธนาคารยูโอบี">ธนาคารยูโอบี</option>
                                    <option value="ธนาคารซีไอเอ็มบีไทย">ธนาคารซีไอเอ็มบีไทย</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>ยอดชำระ</label>
                                <input type="text" class="form-control" value="<?= number_format($row->np_cost, 2) ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>เลขบัญชีผู้โอน</label>
                                <input type="text" class="form-control" name="transfer_account_number">
                            </div>
                            <div class="form-group">
                                <label>ชื่อบัญชีผู้โอน</label>
                                <input type="text" class="form-control" name="transfer_owner">
                            </div>
                            <div class="form-group">
                                <label>วันเวลาที่โอนตามสลิป</label>
                                <input type="datetime-local" class="form-control" name="transfer_datetime">
                            </div>
                            <div class="form-group">
                                <label>อัพโหลดสลิป</label>
                                <input type="file" class="form-control" name="slip" accept="image/*">
                            </div>
                        </div>
                    `;

                    $('#payForm').append(form_html);
                }).fail(function(res) {
                    console.log(res);
                });
            } else {
                return false;
            }
        }

        function checkRadioBank(id) {
            $.ajax({
                method: "get",
                url: "api/bank/readById.php",
                data: {
                    "id": id
                }
            }).done(function(res) {
                $('#receive_bank').val(res.data['name']);
                $('#receive_account_number').val(res.data['account_number']);
                $('#receive_owner').val(res.data['holder']);
            });
        }

        function submit() {

            let fd = new FormData(document.getElementById("payForm"));

            $.ajax({
                method: "post",
                url: "api/notice_payment/pay.php",
                data: fd,
                cache: false,
                contentType: false,
                processData: false
            }).done(function(res) {
                swal({
                    title: "สำเร็จ",
                    text: res.message,
                    icon: "success"
                }).then(() => {
                    window.location = 'current_book.php';
                });
            }).fail(function(res) {
                swal({
                    title: "ผิดพลาด",
                    text: res.responseJSON['message'],
                    icon: "error"
                });
            });
        }
    </script>
</body>

</html>