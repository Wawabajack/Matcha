<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
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
    if (isset($_SESSION['usr']->id))
    {
        $sql = "UPDATE profiles SET online = 0 WHERE uid = :uid";
        $res = $db->prepare($sql);
        $res->bindParam(':uid', $_SESSION['usr']->id);
        $res->execute();
        unset($_SESSION);
        session_destroy();
        header('refresh:0;url=/index.php');
    }
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
    $city = $geoloc['results'][0]['address_components'][0]['long_name'];
    if (isset($city))
        return $city;
    return "";
}

function ft_compare($db, $arr, $tagnb)
{
	$user = getTags($db, $_SESSION['usr']->id);
    if (isset($user->tag))
        $res = explode('#', $user->tag);
    else
    	return 1;
    //var_dump($res);
        if (isset($empty) && $empty == 1)
        	$int = $res;
        else
	        $int = array_intersect($arr, $res);
	    sort($int);
	    var_dump($int);
	    $occ = count($int);
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
