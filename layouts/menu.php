<?php
$current_file = substr($_SERVER['SCRIPT_NAME'], 18);
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
                        <a class="nav-link <?= ($current_file == 'index.php') ? 'active' : '' ?>" href="index.php">หน้าหลัก
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)">บริการ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_file == 'room.php') ? 'active' : '' ?>" href="room.php">ห้องพัก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_file == 'contact.php') ? 'active' : '' ?>" href="contact.php">ติดต่อเรา</a>
                    </li>
                    <?php if (isset($_SESSION['CUSTOMER_LOGIN'])) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= ($current_file == 'daily_book.php' || $current_file == 'monthly_book.php') ? 'active' : '' ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                จองห้องพัก
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="daily_book.php">รายวัน</a>
                                <a class="dropdown-item" href="monthly_book.php">รายเดือน</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                สวัสดี, <?= $_SESSION['CUSTOMER_FIRSTNAME'] ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="profile.php">ข้อมูลส่วนตัว</a>
                                <a class="dropdown-item" href="current_book.php">ห้องพักของฉัน</a>
                                <a class="dropdown-item" href="mybooking.php">ประวัติการใช้งาน</a>
                                <a class="dropdown-item" href="#">แจ้งซ่อมอุปกรณ์</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="logOut()">ออกจากระบบ</a>
                            </div>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_file == 'login.php' || $current_file == 'register.php') ? 'active' : '' ?>" href="login.php">เข้าสู่ระบบ/ลงทะเบียน</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
</header>