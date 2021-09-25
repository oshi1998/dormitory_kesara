function goStep2() {

    let type = $('#inputType').val();
    let moveIn = $('#inputMoveIn').val();

    if (type == "" || type == null) {
        $('#showAlert1').html(
            `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ไม่สามารถไปขั้นตอนต่อไปได้!</strong> กรุณาเลือกรูปแบบห้อง
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `
        );
        $('#inputType').focus();
    } else if (moveIn == "" || moveIn == null) {
        $('#showAlert1').html(
            `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ไม่สามารถไปขั้นตอนต่อไปได้!</strong> กรุณากำหนดการที่คุณจะย้ายของเข้า
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `
        );
        $('#inputMoveIn').focus();
    } else {
        $.ajax({
            method: "post",
            url: "api/monthly_book/add_book_session.php",
            data: {
                "type": type,
                "move_in": moveIn
            }
        }).done(function (res) {
            console.log(res);
            window.location = 'monthly_book.php?step2';
        }).fail(function (res) {
            $('#showAlert1').html(
                `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>ไม่สามารถไปขั้นตอนต่อไปได้!</strong> ${res.responseJSON['message']}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `
            );
        });
    }
}

function viewDetail(id) {

    $.ajax({
        method: "get",
        url: "api/monthly_room/readById.php",
        data: {
            "id": id
        }
    }).done(function (res) {
        console.log(res);

        let detail_html = `
            <div class="row">
                <div class="col-lg-5 col-12">
                    <img src="admin/dist/img/room/${res.room['img']}" style="width:100%">
                </div>
                <div class="col-lg-7 col-12">
                    <p>${res.room['description']}</p>
                    <p>ชั้น ${res.room['floor']}</p>
                    <p>ราคา ${res.room['price']} บาท</p>
                </div>
            </div>
            <br><hr>
            <div class="row">
        `;

        res.images.forEach(element => {
            detail_html += `
                    
                    <div class="col-lg-4 col-12 mb-2">
                        <img src="admin/dist/img/room/${element['img']}" style="width:100%;height:200px">
                    </div>
                
                `;
        });

        detail_html += '</div>';

        if (res.room['img_position'] != "") {
            detail_html += `
            <br><hr>
            <div class="row">
                <div class="col-12">
                    <img src="admin/dist/img/room/${res.room['img_position']}" style="width:100%">
                </div>
            </div>
        `;
        }

        $('#myModalLabel').text('รายละเอียดเพิ่มเติมห้อง ' + id);
        $('#myModalBody').html(detail_html);
        $('#myModal').modal('show');
    }).fail(function (res) {
        console.log(res);
    });
}

function goStep3(id, price) {
    swal({
        title: "ยืนยันเลือกห้อง " + id + "?",
        icon: "warning",
        buttons: true,
    }).then((willConfirm) => {
        if (willConfirm) {
            $.ajax({
                method: "post",
                url: "api/monthly_book/add_room_book_session.php",
                data: {
                    "id": id,
                    "price": price
                }
            }).done(function (res) {
                console.log(res);
                window.location = 'monthly_book.php?step3';
            }).fail(function (res) {
                console.log(res);
            });
        } else {
            return;
        }
    });
}

function book() {
    swal({
        title: "ยืนยันการดำเนินการจอง?",
        text: "หากยืนยันไปแล้ว จะไม่สามารถย้อนกลับมาแก้ไขใดๆ ได้",
        icon: "warning",
        buttons: true,
    }).then((willConfirm) => {
        if (willConfirm) {
            $.ajax({
                method: "GET",
                url: "api/monthly_book/create.php",
            }).done(function (res) {
                console.log(res);
                window.location = 'current_book.php';
            }).fail(function (res) {
                console.log(res);
            });
        } else {
            return;
        }
    });
}
