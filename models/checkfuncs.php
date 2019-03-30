<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
    require_once ('queryfuncs.php');


    function lenCheck($db, $post) {
        $err = 0;
        if (isThere($db, 'username', 'users',$post['username'], 'username'))
            $err = 4;
        if (isThere($db, 'mail', 'users', $post['mail'], 'mail'))
            $err = 11;
        if (strlen($post['username']) < 4 || strlen($post['username']) > 20)
            $err = 5;
        if (!ctype_alnum($post['username']))
            $err = 9;
        if (strlen($post['name']) < 2 || strlen($post['name']) > 20)
            $err = 6;
        if (strlen($post['surname']) < 2 || strlen($post['surname']) > 20)
            $err = 7;
        if (strlen($post['pwd']) < 7 || ctype_digit($post['pwd'])
            || ctype_alpha($post['pwd']) || ctype_lower($post['pwd'])
            || ctype_alnum($post['pwd']) || strlen($post['pwd']) > 30)
            $err = 8;
        return $err;
    }

    function isValid($field, $val) {
        // $_POST[value] empty
        if ($val == "")
            return 1;
        // classic str check
        if ($field == "username" || $field == "surname" || $field == "name" && ctype_alpha($val) && strlen($val) < 11)
            return 1;
        // location check
        else if ($field == "location" && strlen($val) < 51 && filter_var($val, FILTER_SANITIZE_STRING))
            return 1;
        // mail check
        else if ($field == "mail" && filter_var($val, FILTER_VALIDATE_EMAIL))
            return 1;
        // birthdate check
        else if ($field == "birth" && DateTime::createFromFormat('d/m/Y', $val) && $arr = explode('/', $val)) {
            foreach($arr as &$val)
                $val = (int)$val;
            if (isset($arr[0]) && isset($arr[1]) && isset($arr[2]) && checkdate($arr[1], $arr[0], $arr[2]))
                return 1;
        }
        // gender check
        else if ($field == "gender" && ctype_alpha($val)) {
            $c = substr(ucfirst($val), 0, 1);
            if ($c == "M" || $c == "N" || $c == "F")
                return 1;
        }
        // lf check
        else if ($field == "lf" && ctype_alpha($val)) {
            $c = substr(ucfirst($val), 0, 1);
            if ($c == "M" || $c == "N" || $c == "F")
                return 1;
        }
        return 0;
    }

    function keyCheck($db, $userKey) {
        if (filter_var($userKey, FILTER_SANITIZE_URL) != $userKey)
            return 0;
        $user = getUserKey($db, $userKey);
        if (isset($user->id))
            $key = getUserInfo($db, $user)->mail_key;
        if (isset($key) && $key == $userKey)
            return 1;
        return 0;
    }

    function strCheck($usr) {
        if (filter_var($usr, FILTER_SANITIZE_SPECIAL_CHARS) !== $usr)
            return 0;
        return 1;
    }

    function passwordCheck($db, $usr, $pwd) {
        $hashedPass = loadUserInfo($db, $usr)->password;
        if (!password_verify($pwd, $hashedPass))
            return 0;
        return 1;
    }

    function postRegCheck($db, $post){
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

    function checkUserEdit($post) {
        $arr = array("username", "surname", "name", "gender", "mail", "birth", "location");
        foreach ($arr as $val) {
            if (isset($post[$val]) && $post[$val] = trim($post[$val]))
                if (!isValid($val, $post[$val]))
                    return 0;
        }       //echo 'checking $_POST[' . $val . '] : ' . $post[$val] . isValid($val, $post[$val]) . '<br/>';
        return ($post);
    }

    function profileUpdate($db, $elems, $uid)
    {
        $prefs = isThere($db, 'id', 'preferences', $uid, '*');
        $profile = isThere($db, 'id', 'profiles', $uid, '*');
        if (!isset($profile['id']))
            createProfile($db, $uid);
        foreach ($elems as $key => $val) {
            $table = "users";
            if ($key == "gender" || $key == "birthdate")
                $table = "profiles";
            if ($key != "file" && $key != "location" && $key != "lf" && $val != "")
                fieldUpdate($db, $val, $uid, $key, $table);
        }
    }
    /**             TODO: SQL REQ FUNCTIONS                   **/

?>
