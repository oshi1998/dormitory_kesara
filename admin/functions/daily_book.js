function read() {

    $('#btnStatus1').addClass('active');

    $.ajax({
        method: "post",
        url: "api/daily_book/readByStatus1.php",
    }).done(function (res) {

        let data_html = `
            <thead>
                <tr>
                    <th>ข้อมูลจอง</th>
                    <th>ข้อมูลลูกค้า</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="databody">`;

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>
                        รหัส: <span class="badge badge-btn badge-success">${element['id']}</span> <br>
                        ห้อง: ${element['daily_room_id']} <br>
                        ช่วงวันที่: ${element['daterange']} <br>
                        ระยะเวลา: ${element['duration']} คืน <br>
                        เวลา: ${element['time']} น. <br>
                        ค่ามัดจำ: ${element['cost'] / 2} บาท <br>
                        ค่าที่พักทั้งหมด: ${element['cost']} บาท
                    </td>
                    <td>
                        ชื่อผู้ใช้งาน: ${element['username']} <br>
                        ชื่อ-นามสกุล: ${element['firstname'] + " " + element['lastname']} <br>
                        ที่อยู่: ${element['address']} <br>
                        เบอร์โทร: ${element['phone_number']} <br>
                        อีเมล: ${element['email']}
                    </td> 
                    <td>${element['status']}</td>
                    <td>
                        <button class="btn btn-success" onclick="approve('${element['id']}')">
                            <i class="fas fa-check"></i>
                            อนุมัติ
                        </button>
                        <button class="btn btn-danger" onclick="refuse('${element['id']}')">
                            <i class="fas fa-times"></i>
                            ปฏิเสธ
                        </button>
                    </td>
                </tr>
            `;
        });

        data_html += "</tbody>";

        $('#dataTable').html(data_html);

        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        toastr.success(res.message);
    }).fail(function (res) {
        toastr.error(res.responseJSON['message']);
    });
}

function readByStatus1() {

    $('#btnStatus1').addClass('active');
    $('#btnStatus2').removeClass('active');
    $('#btnStatus3').removeClass('active');
    $('#btnStatus4').removeClass('active');
    $('#btnStatus5').removeClass('active');
    $('#btnStatus6').removeClass('active');
    $('#btnStatus7').removeClass('active');

    $('#dataTable').DataTable().destroy();
    $('#dataTable').empty();

    $.ajax({
        method: "post",
        url: "api/daily_book/readByStatus1.php",
    }).done(function (res) {

        let data_html = `
            <thead>
                <tr>
                    <th>ข้อมูลจอง</th>
                    <th>ข้อมูลลูกค้า</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="databody">`;

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>
                        รหัส: <span class="badge badge-btn badge-success">${element['id']}</span> <br>
                        ห้อง: ${element['daily_room_id']} <br>
                        ช่วงวันที่: ${element['daterange']} <br>
                        ระยะเวลา: ${element['duration']} คืน <br>
                        เวลา: ${element['time']} น. <br>
                        ค่ามัดจำ: ${element['cost'] / 2} บาท <br>
                        ค่าที่พักทั้งหมด: ${element['cost']} บาท
                    </td>
                    <td>
                        ชื่อผู้ใช้งาน: ${element['username']} <br>
                        ชื่อ-นามสกุล: ${element['firstname'] + " " + element['lastname']} <br>
                        ที่อยู่: ${element['address']} <br>
                        เบอร์โทร: ${element['phone_number']} <br>
                        อีเมล: ${element['email']}
                    </td> 
                    <td>${element['status']}</td>
                    <td>
                        <button class="btn btn-success" onclick="approve('${element['id']}')">
                            <i class="fas fa-check"></i>
                            อนุมัติ
                        </button>
                        <button class="btn btn-danger" onclick="refuse('${element['id']}')">
                            <i class="fas fa-times"></i>
                            ปฏิเสธ
                        </button>
                    </td>
                </tr>
            `;
        });

        data_html += "</tbody>";

        $('#dataTable').html(data_html);

        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        toastr.success(res.message);
    }).fail(function (res) {
        toastr.error(res.responseJSON['message']);
    });
}

function readByStatus2() {

    $('#btnStatus1').removeClass('active');
    $('#btnStatus2').addClass('active');
    $('#btnStatus3').removeClass('active');
    $('#btnStatus4').removeClass('active');
    $('#btnStatus5').removeClass('active');
    $('#btnStatus6').removeClass('active');
    $('#btnStatus7').removeClass('active');

    $('#dataTable').DataTable().destroy();
    $('#dataTable').empty();

    $.ajax({
        method: "post",
        url: "api/daily_book/readByStatus2.php",
    }).done(function (res) {

        let data_html = `
            <thead>
                <tr>
                    <th>ข้อมูลจอง</th>
                    <th>ข้อมูลลูกค้า</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="databody">`;

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>
                        รหัส: <span class="badge badge-btn badge-success">${element['id']}</span> <br>
                        ห้อง: ${element['daily_room_id']} <br>
                        ช่วงวันที่: ${element['daterange']} <br>
                        ระยะเวลา: ${element['duration']} คืน <br>
                        เวลา: ${element['time']} น. <br>
                        ค่ามัดจำ: ${element['cost'] / 2} บาท <br>
                        ค่าที่พักทั้งหมด: ${element['cost']} บาท
                    </td>
                    <td>
                        ชื่อผู้ใช้งาน: ${element['username']} <br>
                        ชื่อ-นามสกุล: ${element['firstname'] + " " + element['lastname']} <br>
                        ที่อยู่: ${element['address']} <br>
                        เบอร์โทร: ${element['phone_number']} <br>
                        อีเมล: ${element['email']}
                    </td> 
                    <td>${element['status']}</td>
                    <td>
                        <button class="btn btn-danger" onclick="refuse('${element['id']}')">
                            <i class="fas fa-times"></i>
                            ปฏิเสธ
                        </button>
                    </td>
                </tr>
            `;
        });

        data_html += "</tbody>";

        $('#dataTable').html(data_html);

        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        toastr.success(res.message);
    }).fail(function (res) {
        toastr.error(res.responseJSON['message']);
    });
}

function readByStatus3() {

    $('#btnStatus1').removeClass('active');
    $('#btnStatus2').removeClass('active');
    $('#btnStatus3').addClass('active');
    $('#btnStatus4').removeClass('active');
    $('#btnStatus5').removeClass('active');
    $('#btnStatus6').removeClass('active');
    $('#btnStatus7').removeClass('active');

    $('#dataTable').DataTable().destroy();
    $('#dataTable').empty();

    $.ajax({
        method: "post",
        url: "api/daily_book/readByStatus3.php",
    }).done(function (res) {

        console.log(res);

        let data_html = `
            <thead>
                <tr>
                    <th>ข้อมูลจอง</th>
                    <th>ข้อมูลลูกค้า</th>
                    <th>ข้อมูลชำระค่ามัดจำ</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="databody">`;

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>
                        รหัส: <span class="badge badge-btn badge-success">${element['id']}</span> <br>
                        ห้อง: ${element['daily_room_id']} <br>
                        ช่วงวันที่: ${element['daterange']} <br>
                        ระยะเวลา: ${element['duration']} คืน <br>
                        เวลา: ${element['time']} น. <br>
                        ค่ามัดจำ: ${element['cost'] / 2} บาท <br>
                        ค่าที่พักทั้งหมด: ${element['cost']} บาท
                    </td>
                    <td>
                        ชื่อผู้ใช้งาน: ${element['username']} <br>
                        ชื่อ-นามสกุล: ${element['firstname'] + " " + element['lastname']} <br>
                        ที่อยู่: ${element['address']} <br>
                        เบอร์โทร: ${element['phone_number']} <br>
                        อีเมล: ${element['email']}
                    </td> 
                    <td>
                        รหัส: ${element['dep_id']} <button class="btn btn-info btn-sm" onclick="viewSlip('${element['dep_id']}','${element['slip']}')">ดูสลิป</button> <br><hr>
                        <strong>ข้อมูลผู้รับเงิน</strong> <br>
                        ธนาคาร: ${element['receive_bank']} <br> 
                        เลขบัญชี: ${element['receive_account_number']} <br> 
                        เจ้าของบัญชี: ${element['receive_owner']} <br><hr>
                        <strong>ข้อมูลผู้โอนเงิน</strong> <br>
                        ธนาคาร: ${element['transfer_bank']} <br> 
                        เลขบัญชี: ${element['transfer_account_number']} <br>
                        เจ้าของบัญชี: ${element['transfer_owner']} <br>
                        เวลาโอน : ${element['transfer_datetime']} <br>
                    </td>
                    <td>${element['status']}</td>
                    <td>
                        <button class="btn btn-success" onclick="approveDeposit('${element['id']}')">
                            <i class="fas fa-check"></i>
                            อนุมัติ
                        </button>
                        <button class="btn btn-danger" onclick="refuse('${element['id']}')">
                            <i class="fas fa-times"></i>
                            ปฏิเสธ
                        </button>
                    </td>
                </tr>
            `;
        });

        data_html += "</tbody>";

        $('#dataTable').html(data_html);

        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        toastr.success(res.message);
    }).fail(function (res) {
        toastr.error(res.responseJSON['message']);
    });
}

function readByStatus4() {

    $('#btnStatus1').removeClass('active');
    $('#btnStatus2').removeClass('active');
    $('#btnStatus3').removeClass('active');
    $('#btnStatus4').addClass('active');
    $('#btnStatus5').removeClass('active');
    $('#btnStatus6').removeClass('active');
    $('#btnStatus7').removeClass('active');

    $('#dataTable').DataTable().destroy();
    $('#dataTable').empty();

    $.ajax({
        method: "post",
        url: "api/daily_book/readByStatus4.php",
    }).done(function (res) {

        let data_html = `
            <thead>
                <tr>
                    <th>ข้อมูลจอง</th>
                    <th>ข้อมูลลูกค้า</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="databody">`;

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>
                        รหัส: <span class="badge badge-btn badge-success">${element['id']}</span> <br>
                        ห้อง: ${element['daily_room_id']} <br>
                        ช่วงวันที่: ${element['daterange']} <br>
                        ระยะเวลา: ${element['duration']} คืน <br>
                        เวลา: ${element['time']} น. <br>
                        ค่ามัดจำ: ${element['cost'] / 2} บาท <br>
                        ค่าที่พักทั้งหมด: ${element['cost']} บาท
                    </td>
                    <td>
                        ชื่อผู้ใช้งาน: ${element['username']} <br>
                        ชื่อ-นามสกุล: ${element['firstname'] + " " + element['lastname']} <br>
                        ที่อยู่: ${element['address']} <br>
                        เบอร์โทร: ${element['phone_number']} <br>
                        อีเมล: ${element['email']}
                    </td> 
                    <td>${element['status']}</td>
                    <td>
                        <button class="btn btn-success" onclick="checkIn('${element['id']}')">
                            <i class="fas fa-check"></i>
                            เช็คอิน
                        </button>
                        <button class="btn btn-danger" onclick="refuse('${element['id']}')">
                            <i class="fas fa-times"></i>
                            ปฏิเสธ
                        </button>
                    </td>
                </tr>
            `;
        });

        data_html += "</tbody>";

        $('#dataTable').html(data_html);

        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        toastr.success(res.message);
    }).fail(function (res) {
        toastr.error(res.responseJSON['message']);
    });
}

function readByStatus5() {

    $('#btnStatus1').removeClass('active');
    $('#btnStatus2').removeClass('active');
    $('#btnStatus3').removeClass('active');
    $('#btnStatus4').removeClass('active');
    $('#btnStatus5').addClass('active');
    $('#btnStatus6').removeClass('active');
    $('#btnStatus7').removeClass('active');

    $('#dataTable').DataTable().destroy();
    $('#dataTable').empty();

    $.ajax({
        method: "post",
        url: "api/daily_book/readByStatus5.php",
    }).done(function (res) {

        let data_html = `
            <thead>
                <tr>
                    <th>ข้อมูลจอง</th>
                    <th>ข้อมูลลูกค้า</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="databody">`;

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>
                        รหัส: <span class="badge badge-btn badge-success">${element['id']}</span> <br>
                        ห้อง: ${element['daily_room_id']} <br>
                        ช่วงวันที่: ${element['daterange']} <br>
                        ระยะเวลา: ${element['duration']} คืน <br>
                        เวลา: ${element['time']} น. <br>
                        ค่ามัดจำ: ${element['cost'] / 2} บาท <br>
                        ค่าที่พักทั้งหมด: ${element['cost']} บาท
                    </td>
                    <td>
                        ชื่อผู้ใช้งาน: ${element['username']} <br>
                        ชื่อ-นามสกุล: ${element['firstname'] + " " + element['lastname']} <br>
                        ที่อยู่: ${element['address']} <br>
                        เบอร์โทร: ${element['phone_number']} <br>
                        อีเมล: ${element['email']}
                    </td> 
                    <td>
                    ${element['status']} <br><hr>
                    เช็คอินเมื่อ: ${element['check_in_datetime']}
                    </td>
                    <td>
                        <button class="btn btn-success" onclick="checkOut('${element['id']}')">
                            <i class="fas fa-check"></i>
                            เช็คเอาท์
                        </button>
                    </td>
                </tr>
            `;
        });

        data_html += "</tbody>";

        $('#dataTable').html(data_html);

        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        toastr.success(res.message);
    }).fail(function (res) {
        toastr.error(res.responseJSON['message']);
    });
}

function readByStatus6() {

    $('#btnStatus1').removeClass('active');
    $('#btnStatus2').removeClass('active');
    $('#btnStatus3').removeClass('active');
    $('#btnStatus4').removeClass('active');
    $('#btnStatus5').removeClass('active');
    $('#btnStatus6').addClass('active');
    $('#btnStatus7').removeClass('active');

    $('#dataTable').DataTable().destroy();
    $('#dataTable').empty();

    $.ajax({
        method: "post",
        url: "api/daily_book/readByStatus6.php",
    }).done(function (res) {

        let data_html = `
            <thead>
                <tr>
                    <th>ข้อมูลจอง</th>
                    <th>ข้อมูลลูกค้า</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody id="databody">`;

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>
                        รหัส: <span class="badge badge-btn badge-success">${element['id']}</span> <br>
                        ห้อง: ${element['daily_room_id']} <br>
                        ช่วงวันที่: ${element['daterange']} <br>
                        ระยะเวลา: ${element['duration']} คืน <br>
                        เวลา: ${element['time']} น. <br>
                        ค่ามัดจำ: ${element['cost'] / 2} บาท <br>
                        ค่าที่พักทั้งหมด: ${element['cost']} บาท
                    </td>
                    <td>
                        ชื่อผู้ใช้งาน: ${element['username']} <br>
                        ชื่อ-นามสกุล: ${element['firstname'] + " " + element['lastname']} <br>
                        ที่อยู่: ${element['address']} <br>
                        เบอร์โทร: ${element['phone_number']} <br>
                        อีเมล: ${element['email']}
                    </td> 
                    <td>${element['status']} <br><hr>
                    เช็คอินเมื่อ: ${element['check_in_datetime']} <br>
                    เช็คเอาท์เมื่อ: ${element['check_out_datetime']}
                    </td>
                </tr>
            `;
        });

        data_html += "</tbody>";

        $('#dataTable').html(data_html);

        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        toastr.success(res.message);
    }).fail(function (res) {
        toastr.error(res.responseJSON['message']);
    });
}

function readByStatus7() {

    $('#btnStatus1').removeClass('active');
    $('#btnStatus2').removeClass('active');
    $('#btnStatus3').removeClass('active');
    $('#btnStatus4').removeClass('active');
    $('#btnStatus5').removeClass('active');
    $('#btnStatus6').removeClass('active');
    $('#btnStatus7').addClass('active');

    $('#dataTable').DataTable().destroy();
    $('#dataTable').empty();

    $.ajax({
        method: "post",
        url: "api/daily_book/readByStatus7.php",
    }).done(function (res) {

        let data_html = `
            <thead>
                <tr>
                    <th>ข้อมูลจอง</th>
                    <th>ข้อมูลลูกค้า</th>
                    <th>สถานะ</th>
                    <th>สาเหตุ</th>
                </tr>
            </thead>
            <tbody id="databody">`;

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>
                        รหัส: <span class="badge badge-btn badge-success">${element['id']}</span> <br>
                        ห้อง: ${element['daily_room_id']} <br>
                        ช่วงวันที่: ${element['daterange']} <br>
                        ระยะเวลา: ${element['duration']} คืน <br>
                        เวลา: ${element['time']} น. <br>
                        ค่ามัดจำ: ${element['cost'] / 2} บาท <br>
                        ค่าที่พักทั้งหมด: ${element['cost']} บาท
                    </td>
                    <td>
                        ชื่อผู้ใช้งาน: ${element['username']} <br>
                        ชื่อ-นามสกุล: ${element['firstname'] + " " + element['lastname']} <br>
                        ที่อยู่: ${element['address']} <br>
                        เบอร์โทร: ${element['phone_number']} <br>
                        อีเมล: ${element['email']}
                    </td> 
                    <td>${element['status']}</td>
                    <td>${element['note']}</td>
                </tr>
            `;
        });

        data_html += "</tbody>";

        $('#dataTable').html(data_html);

        $('#dataTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        toastr.success(res.message);
    }).fail(function (res) {
        toastr.error(res.responseJSON['message']);
    });
}

function countNotification() {
    $.ajax({
        method: "get",
        url: "api/daily_book/count_notification.php",
    }).done(function (res) {
        console.log(res);
        $('#status1').text(res.data['cs1']);
        $('#status2').text(res.data['cs2']);
        $('#status3').text(res.data['cs3']);
        $('#status4').text(res.data['cs4']);
        $('#status5').text(res.data['cs5']);
        $('#status6').text(res.data['cs6']);
        $('#status7').text(res.data['cs7']);
    });
}

function approve(id) {
    swal({
        title: "ยืนยันการอนุมัติหมายเลขจอง " + id + " ?",
        text: "หากดำเนินการไปแล้ว จะไม่สามารถกลับมาแก้ไขได้!",
        icon: "warning",
        buttons: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/daily_book/approve.php",
                data: {
                    "id": id
                }
            }).done(function (res) {
                console.log(res);
                toastr.success(res.message);
                readByStatus1();
                countNotification();
            }).fail(function (res) {
                console.log(res);
                toastr.error(res.responseJSON['message']);
            });
        } else {
            return;
        }
    });
}

function approveDeposit(id) {
    swal({
        title: "ยืนยันการอนุมัติชำระค่ามัดจำหมายเลขจอง " + id + " ?",
        text: "หากดำเนินการไปแล้ว จะไม่สามารถกลับมาแก้ไขได้!",
        icon: "warning",
        buttons: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/daily_book/approve_deposit.php",
                data: {
                    "id": id
                }
            }).done(function (res) {
                console.log(res);
                toastr.success(res.message);
                readByStatus1();
                countNotification();
            }).fail(function (res) {
                console.log(res);
                toastr.error(res.responseJSON['message']);
            });
        } else {
            return;
        }
    });
}

function checkIn(id) {
    swal({
        title: "ยืนยันการเช็คอินหมายเลขจอง " + id + " ?",
        text: "หากดำเนินการไปแล้ว จะไม่สามารถกลับมาแก้ไขได้!",
        icon: "warning",
        buttons: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/daily_book/check_in.php",
                data: {
                    "id": id
                }
            }).done(function (res) {
                console.log(res);
                toastr.success(res.message);
                readByStatus1();
                countNotification();
            }).fail(function (res) {
                console.log(res);
                toastr.error(res.responseJSON['message']);
            });
        } else {
            return;
        }
    });
}

function checkOut(id) {
    swal({
        title: "ยืนยันการเช็คเอาท์หมายเลขจอง " + id + " ?",
        text: "หากดำเนินการไปแล้ว จะไม่สามารถกลับมาแก้ไขได้!",
        icon: "warning",
        buttons: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/daily_book/check_out.php",
                data: {
                    "id": id
                }
            }).done(function (res) {
                console.log(res);
                toastr.success(res.message);
                readByStatus1();
                countNotification();
            }).fail(function (res) {
                console.log(res);
                toastr.error(res.responseJSON['message']);
            });
        } else {
            return;
        }
    });
}

function refuse(id) {

    let form_html = `
        <form id="refuseForm">
            <div class="form-group">
                <label>หมายเลขจอง</label>
                <input type="text" class="form-control" name="id" value="${id}" readonly>
            </div>
            <div class="form-group">
                <label>สาเหตุ</label>
                <textarea class="form-control" name="note" id="inputNote" required></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="submitRefuse()">ตกลง</button>
            </div>
        </form>
    `;
    $('#myModalLabel').text('ปฏิเสธหมายเลขจอง ' + id);
    $('#myModalBody').html(form_html);
    $('#myModal').modal('show');
}

function submitRefuse() {
    $.ajax({
        type: "post",
        url: "api/daily_book/refuse.php",
        data: $('#refuseForm').serialize()
    }).done(function (res) {
        console.log(res);
        toastr.success(res.message);
        $('#myModal').modal('toggle');
        readByStatus1();
        countNotification();
    }).fail(function (res) {
        console.log(res);
        toastr.error(res.responseJSON['message']);
    });
}

function viewSlip(id, slip) {
    $('#myModalLabel').text('สลิปโอนค่ามัดจำ ' + id);
    $('#myModalBody').html(
        `
            <img src="dist/img/slip/${slip}" style="width:100%">
        `
    );
    $('#myModal').modal('show');
}