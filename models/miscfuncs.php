<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
require_once('queryfuncs.php');

function error($code)
{
    switch ($code) {
        case 1:
            echo '<script>var erreur = document.getElementById("notif"); erreur.style.disp lay = "block"; erreur.innerHTML = "nom d\'utilisateur inconnu";</script>';
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

function logout()
{
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
    $city = $geoloc['results'][0]['address_components'][2]['long_name'];
    if (isset($city))
        return $city;
    return "";
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

function mapInit($db, $uid)
{
    sendpos($db);
    getloc($db, $uid);
}
