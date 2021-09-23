function read() {
    $.ajax({
        method: "post",
        url: "api/room/read.php",
    }).done(function (res) {

        let data_html = "";

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>${element['id']}</td>
                    <td>${element['name']}</td>
                    <td>${element['floor']}</td>
            `;

            if(element['active']=="พร้อมใช้งาน"){
                data_html +=
                `
                <td>
                    <span class="badge badge-success">${element['active']}</span>
                </td>
                <td>
                    <button class="btn btn-primary" onclick="edit('${element['id']}')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger" onclick="deleteData('${element['id']}')">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button class="btn btn-danger" onclick="disable('${element['id']}')">
                        <i class="fas fa-toilet-paper-slash"></i>
                    </button>
                </td>
            </tr>
                `;
            }else{
                data_html +=
                `
                <td>
                <span class="badge badge-danger">${element['active']}</span>
                </td>
                <td>
                    <button class="btn btn-primary" onclick="edit('${element['id']}')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger" onclick="deleteData('${element['id']}')">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button class="btn btn-success" onclick="enable('${element['id']}')">
                        <i class="fas fa-check"></i>
                    </button>
                </td>
            </tr>
                `;
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
    $.ajax({
        method: "post",
        url: "api/roomtype/read.php",
    }).done(function (res) {
        console.log(res);

        let form_html = `
        <form id="createForm">

            <div class="form-group">
                <input type="text" class="form-control" name="id" id="inputId" onchange="checkId(event.target.value)" placeholder="เลขห้อง (ซ้ำกันไม่ได้)" required>
            </div>

            <div class="form-group">
                <select class="form-control" name="type" required>
                    <option value="" selected disabled>--- เลือกประเภทที่พัก ---</option>
            `;

        res.data.forEach(element => {
            form_html +=
                `
                    <option value="${element['id']}">${element['name']}</option>
                `
        });

        form_html +=
            `
            </select>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="floor" placeholder="ชั้น" required>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="create()" class="btn btn-success">บันทึก</button>
            </div>
        </form>
            `;


        $('#myModalLabel').text('เพิ่มข้อมูลห้องพัก');
        $('#myModalBody').html(form_html);
        $('#myModal').modal('show');
    }).fail(function (res) {
        console.log(res);
        toastr.error(res.responseJSON['message']);
    });
}

function checkId(id) {
    $.ajax({
        method: "post",
        url: "api/room/examine.php",
        data: {
            "id": id
        }
    }).done(function (res) {
        console.log(res);
        if (res.status == true) {
            toastr.success(res.message);
        } else {
            toastr.error(res.message);
            $('#inputId').val("").focus();
        }
    });
}

function create() {
    $.ajax({
        method: "post",
        url: "api/room/create.php",
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

function edit(id) {
    $.ajax({
        method: "post",
        url: "api/roomtype/read.php",
    }).done(function (res) {

        console.log(res);
        var roomtypes = res.data;

        $.ajax({
            method: "get",
            url: "api/room/readById.php",
            data: {
                "id": id
            }
        }).done(function (res) {

            console.log(res);
            let form_html = `
            <form id="updateForm">
    
                <div class="form-group">
                    <input type="text" class="form-control" name="id" value="${res.data['id']}" readonly hidden>
                </div>
    
                <div class="form-group">
                    <select class="form-control" name="type" id="type">
                `;

            roomtypes.forEach(element => {
                form_html +=
                    `
                        <option value="${element['id']}">${element['name']}</option>
                    `
            });

            form_html +=
                `
                </select>
                </div>
    
                <div class="form-group">
                    <input type="text" class="form-control" name="floor" value="${res.data['floor']}" placeholder="ชั้น" required>
                </div>
    
                <div class="modal-footer">
                    <button type="button" onclick="update()" class="btn btn-success">บันทึก</button>
                </div>
            </form>
                `;

            $('#myModalLabel').text('แก้ไขข้อมูลห้อง ' + id);
            $('#myModalBody').html(form_html);
            $('#type').val(res.data['type']);
            $('#myModal').modal('show');
        }).fail(function (res) {
            console.log(res);
            toastr.error(res.responseJSON['message']);
        });
    }).fail(function (res) {
        console.log(res);
        toastr.error(res.responseJSON['message']);
    });
}

function update() {
    $.ajax({
        method: "post",
        url: "api/room/update.php",
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

function deleteData(id) {
    swal({
        title: "คุณต้องการลบข้อมูล " + id + "?",
        text: "หากทำการลบไปแล้ว จะไม่สามารถกู้ข้อมูลคืนได้!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/room/delete.php",
                data: {
                    "id": id
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

function enable(id) {
    swal({
        title: "เปิดใช้งานห้องพักเลข " + id + "?",
        icon: "info",
        buttons: true,
    }).then((willEnable) => {
        if (willEnable) {
            $.ajax({
                type: "get",
                url: "api/room/enable.php",
                data: {
                    "id": id
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

function disable(id) {
    swal({
        title: "ปิดใช้งานห้องพักเลข " + id + "?",
        icon: "info",
        buttons: true,
    }).then((willDisable) => {
        if (willDisable) {
            $.ajax({
                type: "get",
                url: "api/room/disable.php",
                data: {
                    "id": id
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