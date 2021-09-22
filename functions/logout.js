function logOut(){
    $.ajax({
        method : "get",
        url : "api/auth/logout.php",
        success : function(){
            window.location = 'index.php'
        }
    });
}