function dailyDeposit(id, amount) {
    $.ajax({
        method: "get",
        url: "api/bank/read.php"
    }).done(function (res) {
        console.log(res);
        let form_html =
            `
            <form id="depositForm">

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
                <label>หมายเลขจอง</label>
                <input type="text" class="form-control" name="book_id" value="${id}" readonly>
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
                <input type="text" class="form-control" name="amount" value="${amount}" readonly>
            </div>
            <div class="form-group">
                <label>เลขบัญชีผู้โอน</label>
                <input type="text" class="form-control" name="transfer_account_number" id="transfer_account_number">
            </div>
            <div class="form-group">
                <label>ชื่อบัญชีผู้โอน</label>
                <input type="text" class="form-control" name="transfer_owner" id="transfer_owner">
            </div>
            <div class="form-group">
                <label>วันเวลาที่โอนตามสลิป</label>
                <input type="datetime-local" class="form-control" name="transfer_datetime" id="transfer_datetime">
            </div>
            <div class="form-group">
                <label>อัพโหลดสลิป</label>
                <input type="file" class="form-control" name="slip" id="slip" accept="image/*">
            </div>

            <div id="showAlert"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="submitDailyDeposit()">ตกลง</button>
            </div>
        </form>
        `;

        $('#myModalLabel').text('แบบฟอร์มชำระค่ามัดจำห้องรายวัน ' + id);
        $('#myModalBody').html(form_html);
        $('#myModal').modal('show');

    }).fail(function (res) {
        console.log(res);
    });
}

function checkRadioBank(id) {
    $.ajax({
        method: "get",
        url: "api/bank/readById.php",
        data: {
            "id": id
        }
    }).done(function (res) {
        $('#receive_bank').val(res.data['name']);
        $('#receive_account_number').val(res.data['account_number']);
        $('#receive_owner').val(res.data['holder']);
    });
}

function submitDailyDeposit() {
    let receive_bank = $('#receive_bank').val();
    let transfer_account_number = $('#transfer_account_number').val();
    let transfer_owner = $('#transfer_owner').val();
    let transfer_datetime = $('#transfer_datetime').val();
    let slip = $('#slip').val();

    if (receive_bank == "") {
        $('#showAlert').html(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ข้อมูลไม่ครบ!</strong> กรุณาเลือกธนาคารสำหรับโอนเงิน
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
        return;
    } else if (transfer_account_number == "") {
        $('#showAlert').html(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ข้อมูลไม่ครบ!</strong> กรุณากรอกข้อมูลเลขบัญชีผู้โอน
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
        $('#transfer_account_number').focus();
        return;
    } else if (transfer_owner == "") {
        $('#showAlert').html(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ข้อมูลไม่ครบ!</strong> กรุณากรอกข้อมูลชื่อบัญชีผู้โอน
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
        $('#transfer_owner').focus();
        return;
    } else if (transfer_datetime == "") {
        $('#showAlert').html(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ข้อมูลไม่ครบ!</strong> กรุณาระบุวันเวลาที่โอนเงิน
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
        $('#transfer_datetime').focus();
        return;
    } else if (slip == "") {
        $('#showAlert').html(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ข้อมูลไม่ครบ!</strong> กรุณาอัพโหลดสลิป
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
        $('#slip').focus();
        return;
    } else {

        let fd = new FormData(document.getElementById("depositForm"));

        $.ajax({
            method: "post",
            url: "api/daily_deposit/create.php",
            data: fd,
            cache: false,
            contentType: false,
            processData: false
        }).done(function (res) {
            console.log(res);
            window.location.reload();
        }).fail(function (res) {
            console.log(res);
            swal({
                title: "เกิดข้อผิดพลาด",
                text: res.responseJSON['message'],
                icon: "error"
            });
        });
    }
}

function monthlyDeposit(id, amount) {
    $.ajax({
        method: "get",
        url: "api/bank/read.php"
    }).done(function (res) {
        console.log(res);
        let form_html =
            `
            <form id="depositForm">

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
                <label>หมายเลขจอง</label>
                <input type="text" class="form-control" name="book_id" value="${id}" readonly>
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
                <input type="text" class="form-control" name="amount" value="${amount}" readonly>
            </div>
            <div class="form-group">
                <label>เลขบัญชีผู้โอน</label>
                <input type="text" class="form-control" name="transfer_account_number" id="transfer_account_number">
            </div>
            <div class="form-group">
                <label>ชื่อบัญชีผู้โอน</label>
                <input type="text" class="form-control" name="transfer_owner" id="transfer_owner">
            </div>
            <div class="form-group">
                <label>วันเวลาที่โอนตามสลิป</label>
                <input type="datetime-local" class="form-control" name="transfer_datetime" id="transfer_datetime">
            </div>
            <div class="form-group">
                <label>อัพโหลดสลิป</label>
                <input type="file" class="form-control" name="slip" id="slip" accept="image/*">
            </div>

            <div id="showAlert"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="submitMonthlyDeposit()">ตกลง</button>
            </div>
        </form>
        `;

        $('#myModalLabel').text('แบบฟอร์มชำระค่ามัดจำห้องรายเดือน ' + id);
        $('#myModalBody').html(form_html);
        $('#myModal').modal('show');

    }).fail(function (res) {
        console.log(res);
    });
}

function submitMonthlyDeposit() {
    let receive_bank = $('#receive_bank').val();
    let transfer_account_number = $('#transfer_account_number').val();
    let transfer_owner = $('#transfer_owner').val();
    let transfer_datetime = $('#transfer_datetime').val();
    let slip = $('#slip').val();

    if (receive_bank == "") {
        $('#showAlert').html(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ข้อมูลไม่ครบ!</strong> กรุณาเลือกธนาคารสำหรับโอนเงิน
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
        return;
    } else if (transfer_account_number == "") {
        $('#showAlert').html(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ข้อมูลไม่ครบ!</strong> กรุณากรอกข้อมูลเลขบัญชีผู้โอน
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
        $('#transfer_account_number').focus();
        return;
    } else if (transfer_owner == "") {
        $('#showAlert').html(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ข้อมูลไม่ครบ!</strong> กรุณากรอกข้อมูลชื่อบัญชีผู้โอน
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
        $('#transfer_owner').focus();
        return;
    } else if (transfer_datetime == "") {
        $('#showAlert').html(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ข้อมูลไม่ครบ!</strong> กรุณาระบุวันเวลาที่โอนเงิน
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
        $('#transfer_datetime').focus();
        return;
    } else if (slip == "") {
        $('#showAlert').html(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ข้อมูลไม่ครบ!</strong> กรุณาอัพโหลดสลิป
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
        $('#slip').focus();
        return;
    } else {

        let fd = new FormData(document.getElementById("depositForm"));

        $.ajax({
            method: "post",
            url: "api/monthly_deposit/create.php",
            data: fd,
            cache: false,
            contentType: false,
            processData: false
        }).done(function (res) {
            console.log(res);
            window.location.reload();
        }).fail(function (res) {
            console.log(res);
            swal({
                title: "เกิดข้อผิดพลาด",
                text: res.responseJSON['message'],
                icon: "error"
            });
        });
    }
}

function repair(room_id) {
    let form_html =
        `
        <form id="repairForm">
            <div class="form-group">
                <label>เลขห้อง</label>
                <input type="text" class="form-control" name="room_id" value="${room_id}" readonly>
            </div>
            <div class="form-group">
                <label>หัวข้อเรื่องที่แจ้ง</label>
                <input type="text" class="form-control" name="topic">
            </div>
            <div class="form-group">
                <label>รายละเอียด</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
            <div class="form-group">
                <label>อัพโหลดรูปภาพ</label>
                <input type="file" class="form-control" name="img" accept="image/*">
            </div>

            <div id="showAlert"></div>

            <br>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="submitRepair()">ส่งเรื่อง</button>
            </div>
        </form>
    `;

    $('#myModalLabel').text("แจ้งซ่อมอุปกรณ์ภายในห้อง " + room_id);
    $('#myModalBody').html(form_html);
    $('#myModal').modal('show');
}

function submitRepair() {
    let fd = new FormData(document.getElementById("repairForm"));

    $.ajax({
        method: "post",
        url: "api/repair/create.php",
        data: fd,
        cache: false,
        contentType: false,
        processData: false
    }).done(function (res) {
        console.log(res);
        window.location.reload();
    }).fail(function (res) {
        console.log(res);
        $('#showAlert').html(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ส่งเรื่องไม่ได้!</strong> ${res.responseJSON['message']}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
    });
}

function viewImage(img){
    $('#myModalBody').html(
        `
            <img src="admin/dist/img/repair/${img}" style="width:100%">
        `
    );
    $('#myModal').modal('show');
}