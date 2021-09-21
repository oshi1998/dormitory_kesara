<?php
    $current_file = substr($_SERVER['SCRIPT_NAME'],18);
?>

<header class="">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <h2>DORMITORY <em>KESARA</em></h2>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_file=='index.php') ? 'active' : '' ?>" href="index.php">หน้าหลัก
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)">บริการ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_file=='room.php') ? 'active' : '' ?>" href="room.php">ห้องพัก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_file=='contact.php') ? 'active' : '' ?>" href="contact.php">ติดต่อเรา</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)">เข้าสู่ระบบ/ลงทะเบียน</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>