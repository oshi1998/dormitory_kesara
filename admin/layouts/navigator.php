<?php
$current_file = substr($_SERVER['SCRIPT_NAME'], 24);
?>


<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item">
            <a href="../index.php" target="_blank" class="nav-link">
                <p>
                    เว็บไซต์หน้าบ้าน
                </p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
        <span class="brand-text font-weight-light">
            DORMITORY
        </span>
        <strong class="text-red">KESARA</strong>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="javascript:void(0)" class="d-block"><?= $_SESSION['ADMIN_USERNAME'] ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link <?= ($current_file == 'dashboard.php') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            แดชบอร์ด
                        </p>
                    </a>
                </li>
                <li class="nav-item <?= ($current_file == 'report_general.php' || $current_file == 'report_daily.php' || $current_file == 'report_monthly.php') ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= ($current_file == 'report_general.php' || $current_file == 'report_daily.php' || $current_file == 'report_monthly.php') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-clipboard"></i>
                        <p>
                            รายงาน
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="report_general.php" class="nav-link <?= ($current_file == 'report_general.php') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ทั่วไป</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="report_daily.php" class="nav-link <?= ($current_file == 'report_daily.php') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>การใช้งานห้องรายวัน</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="report_monthly.php" class="nav-link <?= ($current_file == 'report_monthly.php') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>การใช้งานห้องรายเดือน</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="repair.php" class="nav-link <?= ($current_file == 'repair.php') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            แจ้งซ่อมบำรุงห้อง
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="bank.php" class="nav-link <?= ($current_file == 'bank.php') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            บัญชีธนาคาร
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="notice_payment.php" class="nav-link <?= ($current_file == 'notice_payment.php') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            แจ้งชำระเงินห้องรายเดือน
                        </p>
                    </a>
                </li>
                <li class="nav-item <?= ($current_file == 'daily_book.php' || $current_file == 'monthly_book.php') ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= ($current_file == 'daily_book.php' || $current_file == 'monthly_book.php') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            ข้อมูลจองห้องพัก
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="daily_book.php" class="nav-link <?= ($current_file == 'daily_book.php') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายวัน</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="monthly_book.php" class="nav-link <?= ($current_file == 'monthly_book.php') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายเดือน</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?= ($current_file == 'admin.php' || $current_file == 'customer.php') ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= ($current_file == 'admin.php' || $current_file == 'customer.php') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            ผู้ใช้งานระบบ
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="admin.php" class="nav-link <?= ($current_file == 'admin.php') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ผู้ดูแลระบบ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="customer.php" class="nav-link <?= ($current_file == 'customer.php') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ลูกค้า</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?= ($current_file == 'roomtype.php' || $current_file == 'daily_room.php' || $current_file == 'monthly_room.php') ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link <?= ($current_file == 'roomtype.php' || $current_file == 'daily_room.php' || $current_file == 'monthly_room.php') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-bed"></i>
                        <p>
                            ห้องพัก
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="roomtype.php" class="nav-link <?= ($current_file == 'roomtype.php') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ประเภทห้อง</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="daily_room.php" class="nav-link <?= ($current_file == 'daily_room.php') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ห้องพักรายวัน</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="monthly_room.php" class="nav-link <?= ($current_file == 'monthly_room.php') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ห้องพักรายเดือน</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" onclick="logOut()" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            ออกจากระบบ
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>