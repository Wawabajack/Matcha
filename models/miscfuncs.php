<?php

require_once('queryfuncs.php');

function error($code)
{
    switch ($code) {
        case 1:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "nom d\'utilisateur inconnu";</script>';
            break;
        case 2:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Mot de passe incorrect";</script>';
            break;
        case 3:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Erreur lors du traitement de la requête";</script>';
            break;
        case 4:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Nom d\'utilisateur déjà pris";</script>';
            break;
        case 5:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Nom d\'utilisateur trop court ou trop long (4 - 10 lettres)";</script>';
            break;
        case 6:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Nom trop court ou trop long (2 - 10 lettres)";</script>';
            break;
        case 7:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Prénom trop court ou trop long (2 - 10 lettres)";</script>';
            break;
        case 8:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Mot de passe non sécurisé (1 majuscule, 1 chiffre, 1 caractère spécial et 8 - 30 caractères)";</script>';
            break;
        case 9:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Nom d\'utilisateur invalide";</script>';
            break;
        case 10:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Compte inactif, merci de vérifier vos mails";</script>';
            break;
        case 11:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Adresse mail déjà utilisée";</script>';
            break;
        case 12:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Le compte est banni";</script>';
            break;
        case 400:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Bad Request<br/>";</script>';
            break;
        case 401:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Unauthorized";</script>';
            break;
        case 403:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Forbidden";</script>';
            break;
        case 404:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Not Found<br";</script>';
            break;
    }
    return 1;
}

function logout($db)
{
    if (isset($_SESSION['profile']->id))
    {
        $sql = "UPDATE profiles SET online = 0 WHERE uid = :uid";
        $res = $db->prepare($sql);
        $res->bindParam(':uid', $_SESSION['usr']->id);
        $res->execute();
    }
    unset($_SESSION);
    session_destroy();
    header('refresh:0;url=/index.php');
}

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i)
        $pieces[] = $keyspace[random_int(0, $max)];
    return implode('', $pieces);
}

function ip_details($ip)
{
    $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
    $details = json_decode($json, true);
    return $details;
}

function getClientIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    //var_dump($ip);
    if ($ip == "172.18.0.1")
        $ip = "79.85.134.15";
    //var_dump($ip);
    return $ip;
}

function getCity($lat, $lng)
{
    $apiKey = "&key=AIzaSyBtlv6rYn6x-0tL53o99fUtZbUwm4zcCm0";
    $details_url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . ',' . $lng . "&sensor=false" . $apiKey;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $details_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $geoloc = json_decode(curl_exec($ch), true);
    if (isset($geoloc['results'][0]['address_components'][2]))
        $city = $geoloc['results'][0]['address_components'][2]['long_name'];
    else
        $city = $geoloc['results'][0]['address_components'][0]['long_name'];
    //var_dump($geoloc['results'][0]['address_components']);
    if (isset($city))
        return $city;
    return "";
}

function getCommonTags($db, $arr)
{
    $user = getTags($db, $_SESSION['usr']->id);
    if (isset($user->tag))
        $res = explode('#', $user->tag);
    else
        return 1;
    //var_dump($res);
    //echo '<br/>';
    //var_dump($arr);
    //echo '<br/>';
    array_shift($res);
    $i = 0;
    while ($i < count($res))
    {
        $res[$i]=trim($res[$i]);
        $i++;
    }
    $i = 0;
    while ($i < count($arr))
    {
        $arr[$i] = trim($arr[$i]);
        $i++;
    }
    $int = array_intersect($arr, $res);
    sort($int);
    //var_dump($int);
    $occ = count($int);
    return $occ;
}

function ft_compare($db, $arr, $tagnb)
{
    $occ = getCommonTags($db, $arr);
    // echo '<br/>' . $occ . '<br/><br/>';
    if ($occ >= $tagnb)
        return 1;
    return 0;
}

function filterTag($db, $results, $tagnb)
{
	$i = 0;
    $res = array();
    $tag = array();

    while ($i < count($results)) {
        $user = getTags($db, $results[$i]);
        if (isset($user->tag))
            $res[$i] = $user->tag;
        $i++;
    }
    if (!isset($res[0]))
    	return $results;
    $i = 0;
    $j = 0;

    $final = array();
    while ($i < count($res)) {                          // Tant qu'on a pas check tous les utilisateurs
        $tag[$i] = explode('#', $res[$i]);
        //array_shift($tag[$i]);
        if (ft_compare($db, $tag[$i], $tagnb))         // return 0 si le nb d'occurence est < $tagnb
        {
            $final[$j] = $results[$i];
            $j++;
        }
        $i++;
    }

    return $final;
}

function getloc($db, $uid)
{

    $ipaddress = getClientIP();
    $details = ip_details($ipaddress);
    //echo $details['loc'];
    list($lat, $lng) = explode(",", $details['loc']);
    //echo "lat =  $lat ";
    //echo "lng =  $lng ";
    $city = getCity($lat, $lng);
    //$city = "lol";
    if ($city != "")
        fieldUpdate($db,$city, $uid,'city', 'profiles');
    locupdate($db, $uid, $lat, $lng);
}

function sendpos($db)
{
    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("markers");
    $parnode = $dom->appendChild($node);
    $result = getUsermap($db);
    //var_dump($result);

    // Iterate through the rows, adding XML nodes for each
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Add to XML document node
        $node = $dom->createElement("marker");
        $newnode = $parnode->appendChild($node);
        $newnode->setAttribute("id", $row['id']);
        $newnode->setAttribute("uid", $row['uid']);
        //$newnode->setAttribute("address", $row['address']);
        $newnode->setAttribute("lat", $row['lat']);
        $newnode->setAttribute("lng", $row['lng']);
    }
    //echo $dom->saveXML();
    //$dom->formatOutput = true; 
    //$dom->saveXML(); // put string in test1
    $dom->save('map.xml'); // save as file
}

function makeArray($ret) {
    $i = 0;
    $res = array();
    while ($i < count($ret)) {
        if (isset($ret[$i]->uid))
            $res[$i] = $ret[$i]->uid;
        $i++;
    }
    return $res;
}

function mapInit($db, $uid)
{
    sendpos($db);
    getloc($db, $uid);
}

function valswap(&$dist_array, $i)
{
    $tmpdist = $dist_array['dist'][$i];
    $tmpuid = $dist_array['uid'][$i];
    $tmptags = $dist_array['tags'][$i];
    $tmppop = $dist_array['pop'][$i];
    $dist_array['dist'][$i] = $dist_array['dist'][$i + 1];
    $dist_array['dist'][$i + 1] = $tmpdist;
    $dist_array['uid'][$i] = $dist_array['uid'][$i + 1];
    $dist_array['uid'][$i + 1] = $tmpuid;
    $dist_array['tags'][$i] = $dist_array['tags'][$i + 1];
    $dist_array['tags'][$i + 1] = $tmptags;
    $dist_array['pop'][$i] = $dist_array['pop'][$i + 1];
    $dist_array['pop'][$i + 1] = $tmppop;
}

function reorder($dist_array)
{
    sort($dist_array['dist']);
    sort($dist_array['uid']);
    sort($dist_array['pop']);
    sort($dist_array['tags']);
    $arraySize = count($dist_array['dist']);
    //var_dump($arraySize);
    $i = 0;
    while ($i < ($arraySize - 1))
    {
        //echo '<br/><br/>';    
        //var_dump($dist_array['uid'][$i]);
        if ($dist_array['dist'][$i] > $dist_array['dist'][$i + 1])
            valswap($dist_array, $i);
        if ($dist_array['dist'][$i] == $dist_array['dist'][$i + 1])
        {
            if ($dist_array['tags'][$i] > $dist_array['tags'][$i + 1])
                valswap($dist_array, $i);
            if ($dist_array['tags'][$i] == $dist_array['tags'][$i + 1])
            {
                if ($dist_array['pop'][$i] > $dist_array['pop'][$i + 1])
                    valswap($dist_array, $i);
            }
        }
        $i++;
   }
   return $dist_array;
}

function match($db)
{
    //search($db, $minAge, $maxAge, $minPop, $maxPop, $tagReq, $locLimit);
    $date = new DateTime();
    $birth = new DateTime($_SESSION['profile']->birthdate);
    $age = $date->diff($birth)->y;
    //$minAge = round($age - (0.15*$age));
    //$maxAge = round($age + (0.15*$age));
    //var_dump($_SESSION['profile']->popularity);

    //$minPop = round($_SESSION['profile']->popularity - (0.15*$_SESSION['profile']->popularity));
    //$maxPop = round($_SESSION['profile']->popularity + (0.30*$_SESSION['profile']->popularity));
    $minAge = 18;
    $maxAge = 100;
    $minPop = -500;
    $maxPop = 2000;
    $tagReq = 0;
    $loclimit = 10000;
    $res = search($db, $minAge, $maxAge, $minPop, $maxPop, $tagReq, $loclimit);
    if (!isset($res))
        return 0;
    $i = 0;
    while ($i < count($res))
    {
        $matchUsr = getUserInfo($db, $res[$i]);
        $matchTags = getTags($db, $matchUsr->id);
        $matchProfile = getUserProfile($db, $res[$i]);
        $matchPrefs = getUserPrefs($db, $res[$i]);
        if ($matchPrefs->gender != "N" && $matchPrefs->gender != $_SESSION['profile']->gender)
            $i++;
        else 
        {
            $dist['dist'][$i] = dist($_SESSION['profile']->lat, $_SESSION['profile']->lng, $matchProfile->lat, $matchProfile->lng);
            $dist['uid'][$i] = $res[$i];
            $dist['tags'][$i] = getCommonTags($db, explode('#', $matchTags->tag));
            $dist['pop'][$i]  = $matchProfile->popularity;
            $i++;
        }  
    }
    $dist = reorder($dist);
    $inutile = array_splice($dist, 0, 3);
    return $inutile;
    // echo '<script>alert("minAge: ' . $minAge . ' maxAge: ' . $maxAge. ' $minPop: '. $minPop .' $maxPop:' . $maxPop .'");</script>';
}

function search($db, $minAge, $maxAge, $minPop, $maxPop, $tagReq, $locLimit)
{
    $age = filterAge($db, $minAge, $maxAge);
    $pop = filterPop($db, $minPop, $maxPop);
    $popAgeFilter = array_intersect($age, $pop);
    sort($popAgeFilter);
    $tagFilter = filterTag($db, $popAgeFilter,$tagReq);
    sort($tagFilter);
    $locate = locateFilter($db, $tagFilter, $locLimit);
    $gender = genderFilter($db, $locate);
    $res = blockFilter($db, $gender);
    sort($res);
    return $res;
}

function blockFilter($db, $arr)
{
    sort($arr);
    $res = array();
    $i = 0;
    while ($i < count($arr))
    {
        $user = isBlocked($db, $arr[$i]);
        $me = hasBlocked($db, $arr[$i]);
        if ((!isset($user->value) || $user->value != -1) && (!isset($me->value) || $me->value != -1))
            $res[$i] = $arr[$i];
        $i++;
    }
    return $res;
}

function isCompatible($db, $match, $me)
{
    $otherprofile = getUserProfile($db, $match);
    $otherprefs = getUserPrefs($db, $match);
    $myprofile = getUserProfile($db, $me);
    $myprefs = getUserPrefs($db, $me);
    if (isset($myprefs->gender) && isset($myprofile->gender)
        && isset($otherprefs->gender) && isset($otherprofile->gender) && $myprefs->gender == $otherprofile->gender)
        return 1;
    return 0;
}

function genderFilter($db, $locate)
{
    $res = array();
    $i = 0;
    while ($i < count($locate))
    {
        if (isCompatible($db, $locate[$i], $_SESSION['usr']->id))
            $res[$i] = $locate[$i];
        $i++;
    }
    return $res;
}

function dist($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
{
    $rad = M_PI / 180;
    //Calculate distance from latitude and longitude
    $theta = $longitudeFrom - $longitudeTo;
    $dist = sin($latitudeFrom * $rad)
        * sin($latitudeTo * $rad) +  cos($latitudeFrom * $rad)
        * cos($latitudeTo * $rad) * cos($theta * $rad);
    return acos($dist) / $rad * 60 *  1.853;
}

function isInRange($db, $uid, $range)
{
    $user = getUserProfile($db, $uid);
    $cmpLat = $user->lat;
    $cmplng = $user->lng;
    $myLat = $_SESSION['profile']->lat;
    $myLng = $_SESSION['profile']->lng;
    $dist = dist($myLat, $myLng, $cmpLat, $cmplng);
    //echo 'dist: '. $dist . '<br/>' . 'range: '. $range. '<br/><br/>';
    if ($dist <= $range)
        return 1;
    return 0;
}

function locateFilter($db, $arr, $range)
{
    $res = array();
    $i = 0;
    $j = 0;
    while ($i < count($arr)) {
        if (isInRange($db, $arr[$i], $range)) {
            $res[$j] = $arr[$i];
            $j++;
        }
        $i++;
    }
    return $res;
}

