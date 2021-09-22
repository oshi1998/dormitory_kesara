$('#loginForm').submit(function(e){
    e.preventDefault();

    $.ajax({
        method : "post",
        url : "api/auth/login.php",
        data : $(this).serialize()
    }).done(function(res){
        console.log(res);
        window.location = 'index.php';
    }).fail(function(res){
        console.log(res);

        $('#heading').append(
            `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ผิดพลาด!</strong> ${res.responseJSON['message']}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
    });
});