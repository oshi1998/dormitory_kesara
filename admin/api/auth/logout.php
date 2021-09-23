<?php

session_start();
unset($_SESSION['ADMIN_LOGIN']);
unset($_SESSION['ADMIN_USERNAME']);
unset($_SESSION['ADMIN_FIRSTNAME']);
unset($_SESSION['ADMIN_LASTNAME']);

exit;