<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        ระบบจัดการข้อมูลหลังบ้าน DORMITORY KESARA
    </div>
    <!-- Default to the left -->
    <strong>ลิขสิทธิ์ &copy; 2021 <a target="_blank" href="https://www.facebook.com/pragon.juntharangsivorakul.9">Prakorn Junthalungzevorakul</a></strong> ขอสงวนลิขสิทธิ์.
</footer>

<script>
    function logOut() {
        $.ajax({
            method: "get",
            url: "api/auth/logout.php",
            success: function(res) {
                window.location = 'index.php';
            }
        });
    }
</script>