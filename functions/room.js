function viewDetail(id){
    $.ajax({
        method : "get",
        url : "api/roomtype/readById.php",
        data : {
            "id" : id
        }
    }).done(function(res){
        console.log(res);
        
        let detail_html = `
            <div class="row">
                <div class="col-lg-5 col-12">
                    <img src="admin/dist/img/room/${res.room['img']}" style="width:100%">
                </div>
                <div class="col-lg-7 col-12">
                    <p>${res.room['description']}</p>
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
        $('#myModalLabel').text('รายละเอียดเพิ่มเติมห้อง '+res.room['name']);
        $('#myModalBody').html(detail_html);
        $('#myModal').modal('show');
    }).fail(function(res){
        console.log(res);
    });
}