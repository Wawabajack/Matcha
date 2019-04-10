<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
    require_once ('queryfuncs.php');
    require_once ('miscfuncs.php');

    function lenCheck($db, $post) {
        $err = 0;
        if (isThere($db, 'username', 'users',$post['username'], 'username'))
            $err = 4;
        if (isThere($db, 'mail', 'users', $post['mail'], 'mail'))
            $err = 11;
        if (strlen($post['username']) < 4 || strlen($post['username']) > 10)
            $err = 5;
        if (!ctype_alnum($post['username']))
            $err = 9;
        if (strlen($post['name']) < 2 || strlen($post['name']) > 10)
            $err = 6;
        if (strlen($post['surname']) < 2 || strlen($post['surname']) > 10)
            $err = 7;
        if (strlen($post['pwd']) < 7 || ctype_digit($post['pwd'])
            || ctype_alpha($post['pwd']) || ctype_lower($post['pwd'])
            || ctype_alnum($post['pwd']) || strlen($post['pwd']) > 30)
            $err = 8;
        return $err;
    }

    function isValid($db, $field, &$val) {
        // $_POST[value] empty
        if ($val == "")
            return 1;
        if (($field == "oldpwd" && passwordCheck($db, $_SESSION['usr']->username, $val))
            || ($field == "newpwd" && strlen($val) > 6 && !ctype_alnum($val)
                && !ctype_lower($val) && !ctype_digit($val)
                && !ctype_upper($val) && !empty($val) && strlen($val) < 30))
            return 1;
        // classic str check
        if ((((($field == "username" || $field == "surname") && $val = ucfirst(strtolower($val))) || ($field == "name" && $val = strtoupper($val)))) && ctype_alpha($val) && strlen($val) < 11)
            return 1;
        // location check
        else if ($field == "location" && strlen($val) < 51 && filter_var($val, FILTER_SANITIZE_SPECIAL_CHARS) === $val)
            return 1;
        //bio check
        else if ($field == "bio" && strlen($val) < 1000 && filter_var($val, FILTER_SANITIZE_SPECIAL_CHARS) === $val)
            return 1;
        // mail check
        else if ($field == "mail" && filter_var($val, FILTER_VALIDATE_EMAIL))
            return 1;
        // birthdate check
        else if ($field == "birthdate" && DateTime::createFromFormat('d/m/Y', $val) && $arr = explode('/', $val)) {
            foreach($arr as &$val)
                $val = (int)$val;
            if (isset($arr[0]) && isset($arr[1]) && isset($arr[2]) && checkdate($arr[1], $arr[0], $arr[2]) && $val = array($arr))
                return 1;
        }
        // gender check
        else if (($field == "gender"  || $field == "lf") && ctype_alpha($val)) {
            $val = substr(ucfirst($val), 0, 1);
            $val == "M" ? $val = "H" : $val;
            if ($val == "H" || $val == "N" || $val == "F")
                return 1;
        }
        return 0;
    }

    function keyCheck($db, $userKey) {
        if (filter_var($userKey, FILTER_SANITIZE_SPECIAL_CHARS) !== $userKey)
            return 0;
        $user = getUserKey($db, $userKey);
        if (isset($user->id))
            $key = getUserInfo($db, $user->id)->mail_key;
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

    function createTags($db, $uid){
        $sql = "INSERT INTO `tags` (`uid`, `tag`) VALUES (:uid, '')";
        $res = $db->prepare($sql);
        $res->bindParam(':uid', $uid);
        $res->execute();
    }

    function tagUpdate($db, $tags)
    {
        $usr = isThere($db, 'uid', 'tags', $_SESSION['usr']->id, '*');
        if (!isset($usr->tag))
            createTags($db, $_SESSION['usr']->id);
        if (filter_var($tags, FILTER_SANITIZE_EMAIL) !== $tags) {
            $i = 1;
            $arr = preg_split('@(?=#)@', $tags);
            sort($arr);
            // STR STANDARD FORMAT CONVERSION
            while ($i < count($arr))
            {
                $arr[$i] = trim($arr[$i]);
                //echo $arr[$i][0];
                if (isset($arr[$i][0]) && $arr[$i][0] != '#')
                    return;
                $i++;
            }
            $i = 1;
            $res = "";
            while ($i < count($arr))
            {
                $res = $res . ' ' .$arr[$i];
                $i++;
            }
            fieldUpdate($db, $tags, $_SESSION['usr']->id, 'tag','tags');
        }
        return;
    }

    function checkUserEdit($db, &$post) {
        if (isset($post['tag']))
            tagUpdate($db, $post['tag']);
        $arr = array("username", "surname", "name", "gender", "mail", "birthdate", "location", "lf", "bio", "file", "oldpwd", "newpwd");
        foreach ($arr as $val) {
            if (isset($post[$val]) && $post[$val] = trim($post[$val])) {
                //echo 'checking $_POST[' . $val . '] : ' . $post[$val] . isValid($db, $val, $post[$val]) . '<br/>';
                if (!isValid($db, $val, $post[$val]))
                    unset($post[$val]);
                    //echo 'problem with ' . $post[$val] . ' = ' . $val . '<br/>';  }                      /*  Debug   */
                                                                                                                            /*          */
            }
        }
        return $post;
    }

    function checkImage($db, $files) {
        if (isset($files['file']) && isset($files['file']['type']) && substr($files['file']['type'], 0, 5) == "image"
            && isset($files['file']['size']) && $files['file']['size'] < 3000000) {
            if (isset($files['file']['error']) && $files['file']['error'] != 0)
                return 0;
            $try = file_get_contents($files['file']['tmp_name']);
            $namefile = $files['file']['name'];
            $i = 0;
            $imgUserPath = $_SERVER["DOCUMENT_ROOT"] . '/img/'. lcfirst($_SESSION['usr']->username);
            if (is_dir($imgUserPath)) {
                while (file_exists($imgUserPath . '/' . $namefile)) {
                    $namefile = $i . $namefile;
                    $i++;
                }
                file_put_contents($imgUserPath . '/' . $namefile, $try);
            }
            else
            {
                mkdir($imgUserPath);
                while (file_exists($imgUserPath . '/' . $namefile)) {
                    $namefile = $i . $namefile;
                    $i++;
                }
                file_put_contents($imgUserPath . '/' . $namefile, $try);
            }
        fieldUpdate($db, '/img/' . lcfirst($_SESSION['usr']->username) . '/' . $namefile , $_SESSION['usr']->id, 'img', 'profiles');
        return 1;
        }
        else
            return 0;
    }


    function getCityCoords($city, $country)
    {
        $apiKey = "&key=AIzaSyBtlv6rYn6x-0tL53o99fUtZbUwm4zcCm0";
        $details_url = "https://maps.googleapis.com/maps/api/geocode/json?components=locality:" . $city . '|' . $country . $apiKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geoloc = json_decode(curl_exec($ch), true);
        $coords = array();
        if (isset($geoloc['results'][0]['geometry']['location'])) {
            $coords[0] = $geoloc['results'][0]['geometry']['location']['lat'];
            $coords[1] = $geoloc['results'][0]['geometry']['location']['lng'];
            return $coords;
        }
        return 0;
    }

    function profileUpdate($db, $elems, $uid, $file)
    {
        $prefs = isThere($db, "uid", "preferences", $uid, "*");
        $profile = isThere($db, 'uid', 'profiles', $uid, '*');
        if (!isset($profile->id))
            createProfile($db, $uid);
        if (!isset($prefs->id))
            createPrefs($db, $uid);
        checkImage($db, $file);
        mapInit($db, $uid);
        foreach ($elems as $key => $val) {
            //echo $key . ': ' . $val . '<br/>';
            /* Tables selector */
            $table = "users";
            if ($key == "newpwd") {
                $key = "password";
               // $val = password_hash($val, 1);
            }
            if ($key == "gender" || $key == "birthdate" || $key == "location") {
                $table = "profiles";
                if ($key == "location" && $val != "")
                {
                    $loc = getCityCoords($val, 'FR');
                    //var_dump($loc);
                    if (isset($loc[0])) {
                        locupdate($db, $_SESSION['usr']->id, $loc[0], $loc[1]);
                        $val = getCity($loc[0], $loc[1]);
                    fieldUpdate($db, $val, $_SESSION['usr']->id, 'city', 'profiles'); }
                }
            }
            if ($key == "lf" || $key == "bio") {
                $table = "preferences";
                if ($key == "lf")
                    $key = "gender";
            }
            if ($key == "birthdate" && $val) {
                $arr = explode('/', $val);
                $val = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
            }
            if ($key == "username" || $key == "mail"){
                $there = isThere($db, $key, 'users', $val, $key);
                if (isset($there->$key))
                    $val = "";
            }
            if (($key == "username" || $key == "surname" || $key == "name" || $key == "gender"
                    || $key == "mail" || $key == "birthdate" || $key == "lf"
                    || $key == "bio" || $key == "password" || $key == "newpwd") && $val != "")
                    fieldUpdate($db, $val, $uid, $key, $table);//echo 'updating ' . $val .': ' .
        }
        return 1;
    }
    /**             TODO: SQL REQ FUNCTIONS                   **/

?>
