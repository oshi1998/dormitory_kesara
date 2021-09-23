function read() {
    $.ajax({
        method: "post",
        url: "api/admin/read.php",
    }).done(function (res) {

        let data_html = "";

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>${element['username']}</td>
                    <td>${element['firstname'] + " " + element['lastname']}</td>
                    <td>${element['contact']}</td>
                    <td>
                        <button class="btn btn-primary" onclick="edit('${element['username']}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteData('${element['username']}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        $('#databody').html(data_html);

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

function add() {
    let form_html = `
        <form id="createForm">

            <div class="form-group">
                <input type="text" class="form-control" name="username" id="inputUsername" onchange="checkUsername(event.target.value)" placeholder="ชื่อผู้ใช้งาน (ซ้ำกันไม่ได้)" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="firstname" placeholder="ชื่อจริง" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="lastname" placeholder="นามสกุล" required>
            </div>

            <div class="form-group">
                <textarea class="form-control" name="contact" placeholder="ใส่ข้อมูลการติดต่อ (ไม่บังคับ)"></textarea>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="password" placeholder="รหัสผ่าน" required>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="create()" class="btn btn-success">บันทึก</button>
            </div>
        </form>
    `;
    $('#myModalLabel').text('เพิ่มข้อมูลผู้ดูแลระบบ');
    $('#myModalBody').html(form_html);
    $('#myModal').modal('show');
}

function edit(username) {
    $.ajax({
        method: "post",
        url: "api/admin/readByUsername.php",
        data: {
            "username": username
        }
    }).done(function (res) {
        console.log(res);

        let form_html = `
        <form id="updateForm">

            <div class="form-group">
                <input type="text" class="form-control" name="username" value="${username}" hidden readonly>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="firstname" value="${res.data['firstname']}" placeholder="ชื่อจริง" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="lastname" value="${res.data['lastname']}" placeholder="นามสกุล" required>
            </div>

            <div class="form-group">
                <textarea class="form-control" name="contact" value="${res.data['contact']}" placeholder="ใส่ข้อมูลการติดต่อ (ไม่บังคับ)"></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="update()" class="btn btn-success">บันทึก</button>
            </div>
        </form>
        `;

        $('#myModalLabel').text('แก้ไขข้อมูลผู้ดูแลระบบ ' + username);
        $('#myModalBody').html(form_html);
        $('#myModal').modal('show');
    }).fail(function (res) {
        console.log(res);
        toastr.error(res.responseJSON['message']);
    });
}

function update() {
    $.ajax({
        method: "post",
        url: "api/admin/update.php",
        data: $('#updateForm').serialize()
    }).done(function (res) {
        console.log(res);
        toastr.success(res.message);
        $('#myModal').modal('toggle');
        $('#dataTable').DataTable().destroy();
        $('#databody').empty();
        read();
    }).fail(function (res) {
        console.log(res);
        toastr.error(res.responseJSON['message']);
    });
}

function deleteData(username) {
    swal({
        title: "คุณต้องการลบข้อมูล " + username + "?",
        text: "หากทำการลบไปแล้ว จะไม่สามารถกู้ข้อมูลคืนได้!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/admin/delete.php",
                data: {
                    "username": username
                }
            }).done(function (res) {
                console.log(res);
                toastr.success(res.message);
                $('#dataTable').DataTable().destroy();
                $('#databody').empty();
                read();
            }).fail(function (res) {
                console.log(res);
                toastr.error(res.responseJSON['message']);
            });
        } else {
            return;
        }
    });
}

function checkUsername(username) {
    $.ajax({
        method: "post",
        url: "api/admin/examine.php",
        data: {
            "username": username
        }
    }).done(function (res) {
        console.log(res);
        if (res.status == true) {
            toastr.success(res.message);
        } else {
            toastr.error(res.message);
            $('#inputUsername').val("").focus();
        }
    });
}

function create() {
    $.ajax({
        method: "post",
        url: "api/admin/create.php",
        data: $('#createForm').serialize()
    }).done(function (res) {
        console.log(res);
        toastr.success(res.message);
        $('#myModal').modal('toggle');
        $('#dataTable').DataTable().destroy();
        $('#databody').empty();
        read();
    }).fail(function (res) {
        console.log(res);
        toastr.error(res.responseJSON['message']);
    });
}