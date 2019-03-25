<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
    require_once ('queryfuncs.php');


    function lenCheck($db, $post) {
        $err = 0;
        if (isThere($db, 'username', $post['username']))
            $err = 4;
        if (isThere($db, 'mail', $post['mail']))
            $err = 11;
        if (strlen($post['username']) < 4)
            $err = 5;
        if (!ctype_alnum($post['username']))
            $err = 9;
        if (strlen($post['name']) < 2)
            $err = 6;
        if (strlen($post['surname']) < 2)
            $err = 7;
        if (strlen($post['pwd']) < 7 || ctype_digit($post['pwd'])
            || ctype_alpha($post['pwd'])
            || ctype_lower($post['pwd']) || ctype_alnum($post['pwd']))
            $err = 8;
        return $err;
    }

    function keyCheck($db, $userKey) {
        if (filter_var($userKey, FILTER_SANITIZE_URL) != $userKey)
            return 0;
         $user = getUserKey($db, $userKey)->uid;
        $key = getUserInfo($db, $user);
        if (isset($key) && $key == $userKey)
            return $user;
        return 0;
    }

    function strCheck($usr) {
        if (filter_var($usr, FILTER_SANITIZE_SPECIAL_CHARS) !== $usr)
            return 0;
        return 1;
    }

    function passwordCheck($db, $usr, $pwd) {
        $hashedPass = getUserInfo($db, $usr)->password;
        if (!password_verify($pwd, $hashedPass))
            return 0;
        return 1;
    }

    function postRegCheck($db, $post)
    {
        $arr = array("username", "name", "surname", "mail");
        foreach ($arr as $val) {
            if (!isset($post[$val]) || !strCheck($post[$val])) {
                echo '<script>console.log("! Problème avec le champ ' . $val . ' !");</script>';
                return 0;
            }
            $post[$val] = trim($post[$val]);
        }
        return(lenCheck($db, $post));
    }

    /**             TODO: SQL REQ FUNCTIONS                    **/

?>
