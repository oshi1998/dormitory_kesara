function read() {

    $('#btnStatus1').addClass('active');

    $.ajax({
        method: "post",
        url: "api/repair/readByStatus1.php",
    }).done(function (res) {

        let data_html = `
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>ข้อมูลแจ้งซ่อม</th>
                    <th>ข้อมูลลูกค้า</th>
                    <th>รูปภาพ</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="databody">`;

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>${element['created']}</td>
                    <td>
                        รหัส: <span class="badge badge-btn badge-success">${element['id']}</span> <br><hr>
                        หัวข้อ: ${element['topic']} <br>
                        รายละเอียด: ${element['description']} <br>
                        ห้อง: ${element['room_id']} <br>
                    </td>
                    <td>
                        รหัส: ${element['customer_id']} <br>
                        ชื่อ-นามสกุล: ${element['firstname'] + " " + element['lastname']} <br>
                        ที่อยู่: ${element['address']} <br>
                        เบอร์โทร: ${element['phone_number']} <br>
                        อีเมล: ${element['email']}
                    </td>
                    <td>
                    `;

                    if(element['img']!=""){
                        data_html +=
                            `
                                <button class="btn btn-info" onclick="viewImage('${element['img']}')">ดูรูปภาพ</button>
                            `
                    }else{
                        data_html +=
                            `
                                <strong>ไม่มีภาพ</strong>
                            `
                    }
                    
                    data_html += `    
                    </td>
                    <td>${element['status']}</td>
                    <td>
                        <button class="btn btn-success" onclick="accept('${element['id']}')">
                            <i class="fas fa-check"></i>
                            รับเรื่อง
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

    $('#dataTable').DataTable().destroy();
    $('#dataTable').empty();

    $.ajax({
        method: "post",
        url: "api/repair/readByStatus1.php",
    }).done(function (res) {

        let data_html = `
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>ข้อมูลแจ้งซ่อม</th>
                    <th>ข้อมูลลูกค้า</th>
                    <th>รูปภาพ</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="databody">`;

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>${element['created']}</td>
                    <td>
                        รหัส: <span class="badge badge-btn badge-success">${element['id']}</span> <br><hr>
                        หัวข้อ: ${element['topic']} <br>
                        รายละเอียด: ${element['description']} <br>
                        ห้อง: ${element['room_id']} <br>
                    </td>
                    <td>
                        รหัส: ${element['customer_id']} <br>
                        ชื่อ-นามสกุล: ${element['firstname'] + " " + element['lastname']} <br>
                        ที่อยู่: ${element['address']} <br>
                        เบอร์โทร: ${element['phone_number']} <br>
                        อีเมล: ${element['email']}
                    </td>
                    <td>
                    `;

                    if(element['img']!=""){
                        data_html +=
                            `
                                <button class="btn btn-info" onclick="viewImage('${element['img']}')">ดูรูปภาพ</button>
                            `
                    }else{
                        data_html +=
                            `
                                <strong>ไม่มีภาพ</strong>
                            `
                    }
                    
                    data_html += `    
                    </td>
                    <td>${element['status']}</td>
                    <td>
                        <button class="btn btn-success" onclick="accept('${element['id']}')">
                            <i class="fas fa-check"></i>
                            รับเรื่อง
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

    $('#dataTable').DataTable().destroy();
    $('#dataTable').empty();

    $.ajax({
        method: "post",
        url: "api/repair/readByStatus2.php",
    }).done(function (res) {

        let data_html = `
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>ข้อมูลแจ้งซ่อม</th>
                    <th>ข้อมูลลูกค้า</th>
                    <th>รูปภาพ</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody id="databody">`;

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>${element['created']}</td>
                    <td>
                        รหัส: <span class="badge badge-btn badge-success">${element['id']}</span> <br><hr>
                        หัวข้อ: ${element['topic']} <br>
                        รายละเอียด: ${element['description']} <br>
                        ห้อง: ${element['room_id']} <br>
                    </td>
                    <td>
                        รหัส: ${element['customer_id']} <br>
                        ชื่อ-นามสกุล: ${element['firstname'] + " " + element['lastname']} <br>
                        ที่อยู่: ${element['address']} <br>
                        เบอร์โทร: ${element['phone_number']} <br>
                        อีเมล: ${element['email']}
                    </td>
                    <td>
                    `;

                    if(element['img']!=""){
                        data_html +=
                            `
                                <button class="btn btn-info" onclick="viewImage('${element['img']}')">ดูรูปภาพ</button>
                            `
                    }else{
                        data_html +=
                            `
                                <strong>ไม่มีภาพ</strong>
                            `
                    }
                    
                    data_html += `    
                    </td>
                    <td>${element['status']}</td>
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

    $('#dataTable').DataTable().destroy();
    $('#dataTable').empty();

    $.ajax({
        method: "post",
        url: "api/repair/readByStatus3.php",
    }).done(function (res) {

        let data_html = `
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>ข้อมูลแจ้งซ่อม</th>
                    <th>ข้อมูลลูกค้า</th>
                    <th>รูปภาพ</th>
                    <th>สถานะ</th>
                    <th>สาเหตุ</th>
                </tr>
            </thead>
            <tbody id="databody">`;

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>${element['created']}</td>
                    <td>
                        รหัส: <span class="badge badge-btn badge-success">${element['id']}</span> <br><hr>
                        หัวข้อ: ${element['topic']} <br>
                        รายละเอียด: ${element['description']} <br>
                        ห้อง: ${element['room_id']} <br>
                    </td>
                    <td>
                        รหัส: ${element['customer_id']} <br>
                        ชื่อ-นามสกุล: ${element['firstname'] + " " + element['lastname']} <br>
                        ที่อยู่: ${element['address']} <br>
                        เบอร์โทร: ${element['phone_number']} <br>
                        อีเมล: ${element['email']}
                    </td>
                    <td>
                    `;

                    if(element['img']!=""){
                        data_html +=
                            `
                                <button class="btn btn-info" onclick="viewImage('${element['img']}')">ดูรูปภาพ</button>
                            `
                    }else{
                        data_html +=
                            `
                                <strong>ไม่มีภาพ</strong>
                            `
                    }
                    
                    data_html += `    
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

function accept(id) {
    swal({
        title: "ยืนยันการรับเรื่องรหัสซ่อม " + id + " ?",
        text: "หากดำเนินการไปแล้ว จะไม่สามารถกลับมาแก้ไขได้!",
        icon: "warning",
        buttons: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/repair/accept.php",
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
                <label>รหัสแจ้งซ่อม</label>
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
    $('#myModalLabel').text('ปฏิเสธรหัสซ่อม ' + id);
    $('#myModalBody').html(form_html);
    $('#myModal').modal('show');
}

function submitRefuse() {
    $.ajax({
        type: "post",
        url: "api/repair/refuse.php",
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

function viewImage(img){
    $('#myModalBody').html(
        `
            <img src="dist/img/repair/${img}" style="width:100%">
        `
    );
    $('#myModal').modal('show');
}

function countNotification() {
    $.ajax({
        method: "get",
        url: "api/repair/count_notification.php",
    }).done(function (res) {
        console.log(res);
        $('#status1').text(res.data['cs1']);
        $('#status2').text(res.data['cs2']);
        $('#status3').text(res.data['cs3']);
    });
}