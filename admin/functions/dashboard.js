function count(){
    $.ajax({
        method: "get",
        url: "api/dashboard/count.php"
    }).done(function(res){
        console.log(res);
        $('#c1').text(res.data['c1']);
        $('#c2').text(res.data['c2']);
        $('#c3').text(res.data['c3']);
        $('#c4').text(res.data['c4']);
    }).fail(function(res){
        console.log(res);
    });
}