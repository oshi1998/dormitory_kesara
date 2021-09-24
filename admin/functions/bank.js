function read() {
    $.ajax({
        method: "post",
        url: "api/bank/read.php",
    }).done(function (res) {

        let data_html = "";

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>${element['id']}</td>
                    <td>
                        <img class="img-lg" src="dist/img/bank/${element['img']}">
                    </td>
                    <td>
                        ธนาคาร : ${element['name']} <br>
                        เลขบัญชี : ${element['account_number']} <br>
                        สาขา : ${element['branch']} <br>
                        เจ้าของบัญชี : ${element['holder']}
                    </td>
                    <td>
                        <button class="btn btn-primary" onclick="edit('${element['id']}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteData('${element['id']}')">
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
                <img id="output_image" width="100%" height="300px">
            </div>

            <div class="form-group text-center">
                <input type="file" class="form-control" name="img" onchange="previewImg(event)" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="ชื่อธนาคาร" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="account_number" placeholder="เลขบัญชี" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="branch" placeholder="สาขา" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="holder" placeholder="เจ้าของบัญชี" required>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="create()" class="btn btn-success">บันทึก</button>
            </div>
        </form>
    `;
    $('#myModalLabel').text('เพิ่มข้อมูลบัญชีธนาคาร');
    $('#myModalBody').html(form_html);
    $('#myModal').modal('show');
}

function previewImg(event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('output_image');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function edit(id) {
    $.ajax({
        method: "get",
        url: "api/bank/readById.php",
        data: {
            "id": id
        }
    }).done(function (res) {
        console.log(res);

        let form_html = `

        <form id="updateForm">

            <input type="text" name="id" value="${id}" hidden readonly>

            <div class="form-group">
                <img id="output_image" src="dist/img/bank/${res.data['img']}" width="100%" height="300px">
                <input type="text" name="old_img" value="${res.data['img']}" readonly hidden>
            </div>

            <div class="form-group text-center">
                <input type="file" class="form-control" name="img" onchange="previewImg(event)">
            </div>

            <div class="form-group">
                <label>ชื่อธนาคาร</label>
                <input type="text" class="form-control" name="name" value="${res.data['name']}" placeholder="ชื่อธนาคาร" required>
            </div>

            <div class="form-group">
                <label>เลขบัญชี</label>
                <input type="text" class="form-control" name="account_number" value="${res.data['account_number']}" placeholder="เลขบัญชี" required>
            </div>

            <div class="form-group">
                <label>สาขา</label>
                <input type="text" class="form-control" name="branch" value="${res.data['branch']}" placeholder="สาขา" required>
            </div>

            <div class="form-group">
                <label>เจ้าของบัญชี</label>
                <input type="text" class="form-control" name="holder" value="${res.data['holder']}" placeholder="เจ้าของบัญชี" required>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="update()" class="btn btn-success">บันทึก</button>
            </div>
        </form>
        `;

        $('#myModalLabel').text('แก้ไขข้อมูลบัญชีธนาคาร ' + id);
        $('#myModalBody').html(form_html);
        $('#myModal').modal('show');
    }).fail(function (res) {
        console.log(res);
        toastr.error(res.responseJSON['message']);
    });
}

function update() {

    let fd = new FormData(document.getElementById("updateForm"));

    $.ajax({
        method: "post",
        url: "api/bank/update.php",
        data: fd,
        cache: false,
        contentType: false,
        processData: false
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
                url: "api/bank/delete.php",
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

function create() {

    let fd = new FormData(document.getElementById("createForm"));

    $.ajax({
        method: "post",
        url: "api/bank/create.php",
        data: fd,
        cache: false,
        contentType: false,
        processData: false
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