<?php
    require_once('../config/db_connect.php');
    require_once ('queryfuncs.php');

    function strCheck($usr) {
        if (filter_var($usr, FILTER_SANITIZE_SPECIAL_CHARS) !== $usr)
            return 0;
        return 1;
    }

    function passwordCheck($db, $usr, $pwd) {
        $hashedPass = getUserInfo($db, $usr)->password;
        if (hash('sha256', $pwd) !== $hashedPass)
            return 0;
        return 1;
    }

    function postRegCheck($post)
    {
        $arr = array("username", "name", "surname", "mail", "pwd");
        foreach ($arr as $val) {
            if (!isset($post[$val]) || !strCheck($post[$val])) {
                echo '<script>console.log("! Problème avec le champ ' . $val . ' !");</script>';
                return 0;
            }
        }
        return 1;
    }

    /**      TODO: TRIM DATA SPACES BEFORE AND AFTER STR        **/
    /**             TODO: SQL REQ FUNCTIONS                    **/

?>