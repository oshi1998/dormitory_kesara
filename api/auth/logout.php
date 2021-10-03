<?php

session_start();
unset($_SESSION['CUSTOMER_LOGIN']);
unset($_SESSION['CUSTOMER_USERNAME']);
unset($_SESSION['CUSTOMER_FIRSTNAME']);
unset($_SESSION['CUSTOMER_LASTNAME']);
unset($_SESSION['MYBOOK']);

exit();