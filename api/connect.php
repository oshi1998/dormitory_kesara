<?php

error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");

$host = "localhost";
$username = "root";
$password = "";
$db = "dormitory_kesara";

$pdo;
$dsn = "mysql:host=$host;dbname=$db";
$pdo = new PDO($dsn, $username, $password);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
