function read() {
    $.ajax({
        method: "post",
        url: "api/customer/read.php",
    }).done(function (res) {

        let data_html = "";

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>${element['id_card']}</td>
                    <td>${element['firstname'] + " " + element['lastname']}</td>
                    <td>
                        ที่อยู่ : ${element['address']} <br>
                        เบอร์โทร : ${element['phone_number']} <br>
                        อีเมล : ${element['email']}
                    </td>`;


            if (element['active'] == "Enable") {
                data_html +=
                    `
                    <td>
                    <span class="badge badge-pill badge-success">${element['active']}</span>
                    </td>
                    <td>
                        <button class="btn btn-primary" onclick="edit('${element['id_card']}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger" onclick="disable('${element['id_card']}')">
                            <i class="fas fa-user-slash"></i>
                        </button>
                    </td>
                </tr>
                `
            } else {
                data_html +=
                    `
                    <td>
                        <span class="badge badge-pill badge-danger">${element['active']}</span>
                    </td>
                    <td>
                        <button class="btn btn-primary" onclick="edit('${element['id_card']}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-success" onclick="enable('${element['id_card']}')">
                            <i class="fas fa-user-check"></i>
                        </button>
                    </td>
                </tr>
                `
            }
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
            <input type="text" class="form-control" name="firstname" placeholder="ชื่อจริง"required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="lastname" placeholder="นามสกุล" required>
        </div>
        <div class="form-group">
            <select class="form-control" name="gender" required>
                <option value="" selected disabled>--- เลือกเพศ ---</option>
                <option value="ชาย">ชาย</option>
                <option value="หญิง">หญิง</option>
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="id_card" id="inputIdCard" minlength="13" maxlength="13" placeholder="เลขบัตรประจำตัวประชาชน (สำหรับเข้าสู่ระบบ)" onchange="checkIdCard(event.target.value)">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="phone_number" minlength="10" placeholder="เบอร์โทร (มากกว่า 1 เบอร์ได้)" required>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="address" placeholder="ที่อยู่ (ไม่บังคับ)"></textarea>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" id="inputEmail" placeholder="อีเมล" onchange="checkEmail(event.target.value)" required>
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

function edit(id_card) {
    $.ajax({
        method: "post",
        url: "api/customer/readById.php",
        data: {
            "id_card": id_card
        }
    }).done(function (res) {
        console.log(res);

        let form_html = `

        <form id="updateForm">

            <div clas>
                <input type="text" class="form-control" name="id_card" value="${id_card}" readonly hidden>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="firstname" id="inputFirstname" value="${res.data['firstname']}" onchange="checkFirstname(event.target.value)" placeholder="ชื่อจริง" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="lastname" value="${res.data['lastname']}" placeholder="นามสกุล" required>
            </div>
            <div class="form-group">
                <select class="form-control" name="gender" id="gender">
                    <option value="ชาย">ชาย</option>
                    <option value="หญิง">หญิง</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="phone_number" value="${res.data['phone_number']}" minlength="10" placeholder="เบอร์โทร (มากกว่า 1 เบอร์ได้)" required>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="address" value="${res.data['address']}" placeholder="ที่อยู่ (ไม่บังคับ)"></textarea>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" value="${res.data['email']}" id="inputEmail" placeholder="อีเมล" onchange="checkEmail(event.target.value)" required>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="update()" class="btn btn-success">บันทึก</button>
            </div>
        </form>
        `;

        $('#myModalLabel').text('แก้ไขข้อมูลลูกค้า ' + id_card);
        $('#myModalBody').html(form_html);
        $('#gender').val(res.data['gender']);
        $('#myModal').modal('show');
    }).fail(function (res) {
        console.log(res);
        toastr.error(res.responseJSON['message']);
    });
}

function update() {
    $.ajax({
        method: "post",
        url: "api/customer/update.php",
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

function checkIdCard(id_card) {
    $.ajax({
        method: "post",
        url: "api/customer/examine.php",
        data: {
            "id_card": id_card,
            "examine": "id_card"
        }
    }).done(function (res) {
        console.log(res);

        if (res.examine == "Not Empty") {
            toastr.error(res.message);
            $('#inputIdCard').val("").focus();
        }
    }).fail(function (res) {
        console.log(res);
    });
}

function checkEmail(email) {
    $.ajax({
        method: "post",
        url: "api/customer/examine.php",
        data: {
            "email": email,
            "examine": "email"
        }
    }).done(function (res) {
        console.log(res);

        if (res.examine == "Not Empty") {
            toastr.error(res.message);
            $('#inputEmail').val("").focus();
        }
    }).fail(function (res) {
        console.log(res);
    });
}

function enable(id_card) {
    swal({
        title: "คุณต้องการเปิดใช้งานบัญชี " + id_card + "?",
        icon: "info",
        buttons: true,
    }).then((willEnable) => {
        if (willEnable) {
            $.ajax({
                type: "get",
                url: "api/customer/enable.php",
                data: {
                    "id_card": id_card
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

function disable(id_card) {
    swal({
        title: "คุณต้องการปิดใช้งานบัญชี " + id_card + "?",
        icon: "info",
        buttons: true,
    }).then((willDisable) => {
        if (willDisable) {
            $.ajax({
                type: "get",
                url: "api/customer/disable.php",
                data: {
                    "id_card": id_card
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

function create() {
    $.ajax({
        method: "post",
        url: "api/customer/create.php",
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