<?php

session_start();

$current_file = substr($_SERVER['SCRIPT_NAME'], 24);

if ($current_file == 'index.php') {
    if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] = TRUE) {
        header('location:dashboard.php');
    }
} else {
    if (!isset($_SESSION['ADMIN_LOGIN']) || $_SESSION['ADMIN_LOGIN'] != TRUE) {
        header('location:index.php');
    }
}
