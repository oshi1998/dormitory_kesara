<?php

session_start();
unset($_SESSION['CUSTOMER_LOGIN']);
unset($_SESSION['CUSTOMER_ID']);
unset($_SESSION['CUSTOMER_FIRSTNAME']);
unset($_SESSION['CUSTOMER_LASTNAME']);

exit();