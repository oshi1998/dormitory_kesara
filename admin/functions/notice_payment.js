$('#dataTable').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
});

function getRoomDetail(room_id) {
    $.ajax({
        method: "get",
        url: "api/notice_payment/get_room_detail.php",
        data: {
            "id": room_id
        }
    }).done(function (res) {
        console.log(res);
        $('#customer_username').val(res.data['customer_username']);
        $('#customer_name').val(res.data['firstname'] + " " + res.data['lastname']);
        $('#npd_room_cost').val(res.data['cost']);
    }).fail(function (res) {
        toastr.error(res.responseJSON['message']);
    })
}

function create() {
    $.ajax({
        method: "post",
        url: "api/notice_payment/create.php",
        data: $('#newBillForm').serialize()
    }).done(function (res) {
        console.log(res);
        toastr.success(res.message);
        setTimeout(() => {
            window.location.reload();
        }, 500);
    }).fail(function (res) {
        toastr.error(res.responseJSON['message']);
    });
}

function deleteData(np_id) {
    swal({
        title: "คุณต้องการลบข้อมูล " + np_id + "?",
        text: "หากทำการลบไปแล้ว จะไม่สามารถกู้ข้อมูลคืนได้!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/notice_payment/delete.php",
                data: {
                    "id": np_id
                }
            }).done(function (res) {
                console.log(res);
                toastr.success(res.message);
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }).fail(function (res) {
                toastr.error(res.responseJSON['message']);
            });
        } else {
            return;
        }
    });
}

function acceptPay(np_id) {
    swal({
        title: "ยืนยันการชำระเงินสำเร็จ " + np_id + "?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/notice_payment/acceptPay.php",
                data: {
                    "id": np_id
                }
            }).done(function (res) {
                console.log(res);
                toastr.success(res.message);
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }).fail(function (res) {
                toastr.error(res.responseJSON['message']);
            });
        } else {
            return;
        }
    });
}

function refusePay(np_id) {
    swal({
        title: "ยืนยันการปฏิเสธ " + np_id + "?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "get",
                url: "api/notice_payment/refusePay.php",
                data: {
                    "id": np_id
                }
            }).done(function (res) {
                console.log(res);
                toastr.success(res.message);
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }).fail(function (res) {
                toastr.error(res.responseJSON['message']);
            });
        } else {
            return;
        }
    });
}

function viewSlip(id, slip) {
    $('#myModalLabel').text('สลิปโอนค่าเช่าห้อง ' + id);
    $('#myModalBody').html(
        `
            <img src="dist/img/slip/${slip}" style="width:100%">
        `
    );
    $('#myModal').modal('show');
}