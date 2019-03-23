<?php
    require_once($_SERVER["DOCUMENT_ROOT"] .'/views/registerView.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/miscfuncs.php');

    if (isset($_SESSION['register'])) {
        if (isset($_SESSION['error'])) {
	        error($_SESSION['error']);
	        unset($_SESSION['error']);
            unset($_SESSION['register']);
        }
    }
    echo $regForm;
    ?>