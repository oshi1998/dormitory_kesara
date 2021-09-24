$(function () {

    var cost = $('#cost').val();

    let start = moment().startOf('hour');
    let end = moment().startOf('hour').add(24, 'hour');
    $('input[name="checkin"]').val(start.format('YYYY-MM-DD'));
    $('input[name="checkout"]').val(end.format('YYYY-MM-DD'));
    $('input[name="daterange"]').daterangepicker({
        autoApply: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(24, 'hour'),
        minDate: moment().startOf('hour'),
        locale: {
            format: 'Y-MM-DD'
        }
    }, function (start, end) {
        let duration = end.diff(start, 'days');
        $('input[name="checkin"]').val(start.format('YYYY-MM-DD'));
        $('input[name="checkout"]').val(end.format('YYYY-MM-DD'));
        $('input[name="duration"]').val(duration);

        let new_cost = cost * duration;
        $('input[name="cost"]').val(new_cost.toFixed(2));
    });

});

function searchRoom(id) {
    let time = $('#inputTime').val();

    if (time == "") {
        $('#showAlert1').append(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ไม่สามารถค้นหาห้องพักได้!</strong> โปรดระบุเวลา
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
        $('#inputTime').focus();
    } else {
        $.ajax({
            method: "post",
            url: "api/booking/search_daily_room.php",
            data: {
                "id": id,
                "checkin": $('input[name="checkin"]').val(),
                "checkout": $('input[name="checkout"]').val()
            }
        }).done(function (res) {
            console.log(res);
            $('#showAlert1').append(
                `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>สำเร็จ!</strong> ${res.message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                `
            );

            $('#inputTime').prop('readonly', true);
            $('#inputDateRange').prop('disabled', true);
            $('#searchBtn').prop('disabled', true);
            $('#submitBtn').prop('disabled', false);
            $('#cancelBtn').prop('disabled', false);
        }).fail(function (res) {
            console.log(res);
            $('#showAlert1').append(
                `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>เกิดข้อผิดพลาด!</strong> ${res.responseJSON['message']}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                `
            );
        });
    }
}

function cancel() {
    $('#inputTime').val("");
    $('#inputTime').prop('readonly', false);
    $('#inputDateRange').prop('disabled', false);
    $('#searchBtn').prop('disabled', false);
    $('#submitBtn').prop('disabled', true);
    $('#cancelBtn').prop('disabled', true);
}

function submitDailyBook() {
    swal({
        title: "คุณต้องการส่งแบบฟอร์มขอจองที่พักรายวัน ช่วงวันที่ " + $('input[name="daterange"]').val() + "?",
        text: "หากดำเนินการไปแล้ว จะไม่สามารถกลับมาแก้ไขได้!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willConfirm) => {
        if (willConfirm) {
            $.ajax({
                method: "post",
                url: "api/booking/daily_book.php",
                data: $('#dailyBookForm').serialize()
            }).done(function (res) {
                console.log(res);
                swal({
                    title : "สำเร็จ",
                    text : res.message,
                    icon : "success"
                }).then(()=>{
                    window.location = 'mybooking.php'
                });
            }).fail(function (res) {
                console.log(res);
                swal({
                    title : "เกิดข้อผิดพลาด",
                    text : res.responseJSON['message'],
                    icon : "error"
                });
            });
        } else {
            return;
        }
    });


}