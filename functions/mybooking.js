function loadMyCurrentBooking(id_card) {
    $.ajax({
        method: "get",
        url: "api/booking/current_booking.php",
        data: {
            "id_card": id_card
        }
    }).done(function (res) {
        console.log(res);
    }).fail(function (res) {
        console.log(res);
        $('#currentBooking').append(
            `
                <strong>${res.responseJSON['message']}</strong>
            `
        );
    });
}

function loadMyHistoryBooking(id_card) {
    $.ajax({
        method: "get",
        url: "api/booking/history.php",
        data: {
            "id_card": id_card
        }
    }).done(function (res) {
        console.log(res);
        $('#heading').append(`<strong>ประวัติการใช้งาน (${res.data.length})</strong>`);
        if (res.data.length > 0) {

        } else {
            $('#showHistory').append(
                `
                <div class="alert alert-primary" role="alert">
                    ท่านยังไม่เคยมีประวัติการใช้งาน <a href="room.php" class="alert-link">ดูห้องพัก คลิก!</a> ลองมาใช้บริการห้องพักของเราดูสิ
                </div>
                `
            );
        }
    }).fail(function (res) {
        console.log(res);
    });
}