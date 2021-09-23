function read() {
    $.ajax({
        method: "post",
        url: "api/roomtype/read.php",
    }).done(function (res) {

        let data_html = "";

        res.data.forEach(element => {
            data_html += `
                <tr>
                    <td>
                        <img class="img-lg" src="dist/img/room/${element['img']}">
                    </td>
                    <td>${element['name']}</td>
                    <td>${element['description']}</td>
                    <td>${element['price']}</td>
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
                <input type="text" class="form-control" name="name" id="inputName" onchange="checkName(event.target.value)" placeholder="ชื่อประเภท (ซ้ำกันไม่ได้)" required>
            </div>

            <div class="form-group">
                <textarea class="form-control" name="description" placeholder="คำอธิบาย" required></textarea>
            </div>

            <div class="form-group">
                <input type="number" class="form-control" name="price" placeholder="ราคา" required>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="create()" class="btn btn-success">บันทึก</button>
            </div>
        </form>
    `;
    $('#myModalLabel').text('เพิ่มข้อมูลประเภทห้องพัก');
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
        url: "api/roomtype/readById.php",
        data: {
            "id": id
        }
    }).done(function (res) {
        console.log(res);

        let form_html = `
        <form id="updateForm">

            <input type="text" name="id" value="${id}" hidden readonly>

            <div class="form-group">
                <img id="output_image" src="dist/img/room/${res.data['img']}" width="100%" height="300px">
                <input type="text" name="old_img" value="${res.data['img']}" hidden readonly>
            </div>

            <div class="form-group text-center">
                <input type="file" class="form-control" name="img" onchange="previewImg(event)" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="name" value="${res.data['name']}" id="inputName" onchange="checkName(event.target.value)" placeholder="ชื่อประเภท (ซ้ำกันไม่ได้)" required>
            </div>

            <div class="form-group">
                <textarea class="form-control" name="description" placeholder="คำอธิบาย" required>${res.data['description']}</textarea>
            </div>

            <div class="form-group">
                <input type="number" class="form-control" name="price" value="${res.data['price']}" placeholder="ราคา" required>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="update()" class="btn btn-success">บันทึก</button>
            </div>
        </form>
        `;

        $('#myModalLabel').text('แก้ไขข้อมูลประเภทห้อง ' + id);
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
        url: "api/roomtype/update.php",
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

function checkName(name) {
    $.ajax({
        method: "post",
        url: "api/roomtype/examine.php",
        data: {
            "name": name
        }
    }).done(function (res) {
        console.log(res);
        if (res.status == true) {
            toastr.success(res.message);
        } else {
            toastr.error(res.message);
            $('#inputName').val("").focus();
        }
    });
}

function deleteData(id){
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
                url: "api/roomtype/delete.php",
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
        url: "api/roomtype/create.php",
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