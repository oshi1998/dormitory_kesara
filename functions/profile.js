function checkFirstname(firstname) {
    $.ajax({
        method: "post",
        url: "api/register/examine.php",
        data: {
            "firstname": firstname,
            "examine": "firstname"
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
            $('#firstname').val(firstname).focus();
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
            $('#email').val(email).focus();
        }
    }).fail(function (res) {
        console.log(res);
    });
}

function getCustomerData(username) {
    $.ajax({
        method: "post",
        url: "api/customer/read.php",
        data: {
            "username": username,
            "getDataByUsername": "yes"
        }
    }).done(function (res) {
        console.log(res);

        const date = new Date(res.data['created'])

        const created = date.toLocaleDateString('th-TH', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });

        $('#myprofile').append(
            `
                <table class="table table-bordered">
                    <tr>
                        <th>ชื่อ-นามสกุล</th>
                        <td>${res.data['firstname'] + " " + res.data['lastname']}</td>
                    </tr>
                    <tr>
                        <th>เพศ</th>
                        <td>${res.data['gender']}</td>
                    </tr>
                    <tr>
                        <th>เบอร์โทร</th>
                        <td>${res.data['phone_number']}</td>
                    </tr>
                    <tr>
                        <th>ที่อยู่</th>
                        <td>${res.data['address']}</td>
                    </tr>
                    <tr>
                        <th>อีเมล</th>
                        <td>${res.data['email']}</td>
                    </tr>
                    <tr>
                        <th>สถานะ</th>
                        <td>${res.data['status']}</td>
                    </tr>
                    <tr>
                        <th>เข้าร่วมเมื่อ</th>
                        <td>${created}</td>
                    </tr>
                </table>
            `
        );

        $('#firstname').val(res.data['firstname']);
        $('#lastname').val(res.data['lastname']);
        $('#gender').val(res.data['gender']);
        $('#phone_number').val(res.data['phone_number']);
        $('#address').val(res.data['address']);
        $('#email').val(res.data['email']);
    }).fail(function (res) {
        console.log(res);
    });
}

$('#updateProfileForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        method: "post",
        url: "api/profile/update.php",
        data: $(this).serialize()
    }).done(function (res) {
        console.log(res);
        $('#heading').append(
            `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>สำเร็จ!</strong> ${res.message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );

        $('#myprofile').html("");
        getCustomerData(res.username);
    }).fail(function (res) {
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


$('#changePasswordForm').submit(function (e) {
    e.preventDefault();

    $.ajax({
        method: "post",
        url: "api/profile/changePassword.php",
        data: $(this).serialize()
    }).done(function (res) {
        console.log(res);
        $('#heading2').append(
            `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>สำเร็จ!</strong> ${res.message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `
        );
        $('#old_password').val("");
        $('#new_password').val("");
    }).fail(function (res) {
        console.log(res);
        $('#heading2').append(
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