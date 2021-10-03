function checkIdCard(id_card) {
    $.ajax({
        method: "post",
        url: "api/register/examine.php",
        data: {
            "id_card": id_card,
            "examine": "id_card"
        }
    }).done(function (res) {
        console.log(res);

        if (res.examine == "Not Empty") {
            $('#heading').append(
                `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ผิดพลาด!</strong> ${res.message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                `
            );
            $('#inputIdCard').val("").focus();
        }
    }).fail(function (res) {
        console.log(res);
    });
}

function checkUsername(username){
    $.ajax({
        method: "post",
        url: "api/register/examine.php",
        data: {
            "username": username,
            "examine": "username"
        }
    }).done(function (res) {
        console.log(res);

        if (res.examine == "Not Empty") {
            $('#heading').append(
                `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ผิดพลาด!</strong> ${res.message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                `
            );
            $('#inputUsername').val("").focus();
        }
    }).fail(function (res) {
        console.log(res);
    });
}

function checkEmail(email) {
    $.ajax({
        method: "post",
        url: "api/register/examine.php",
        data: {
            "email": email,
            "examine": "email"
        }
    }).done(function (res) {
        console.log(res);

        if (res.examine == "Not Empty") {
            $('#heading').append(
                `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ผิดพลาด!</strong> ${res.message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                `
            );
            $('#inputEmail').val("").focus();
        }
    }).fail(function (res) {
        console.log(res);
    });
}

$('#registerForm').submit(function(e){

    e.preventDefault();

    $.ajax({
        method : "post",
        url : "api/register/create.php",
        data : $(this).serialize()
    }).done(function(){
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
    })
});