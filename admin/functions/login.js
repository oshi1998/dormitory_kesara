$('#loginForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        method: "post",
        url: "api/auth/login.php",
        data: $(this).serialize()
    }).done(function (res) {
        console.log(res);
        window.location = 'dashboard.php';
    }).fail(function (res) {
        console.log(res);
        toastr.error(res.responseJSON['message']);
    });
});