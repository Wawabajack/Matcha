<?php
    session_start();
    require_once('../config/db_connect.php');
    require_once('../scripts/checkfuncs.php');
    require_once('../scripts/queryfuncs.php');
    require_once('../scripts/miscfuncs.php');

    if (isset($_POST['usr']) && isset($_POST['pwd'])) {
        if (strCheck($_POST['usr']) && isThere($db, $_POST['usr'])) {

            /**     Str check ->  existing user ? ->  Retrieve user infos      **/

            if (passwordCheck($db, $_POST['usr'], $_POST['pwd'])) {
                $_SESSION['usr'] = getUserInfo($db, $_POST['usr']);
                header('refresh:0;url=/index.php');
            }
            else
                error(2);
        }
        else
            error(1);
    }

    if (isset($_POST['logout'])) {
        logout(); }


?>