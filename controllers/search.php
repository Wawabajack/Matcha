<?php
    require_once('../views/indexView.php');
    require_once('../models/miscfuncs.php');
    require_once('../views/mapView.php');
    if (isset($_SESSION['usr']->id))
        require_once('../views/ProfileView.php');
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <meta content="Index" name="MatchaWeeb">
    <link href="../css/profile.css" rel="stylesheet" type="text/css">
    <link href="../css/main.css" rel="stylesheet" type="text/css">



    <!------------ Bootstrap includes ------------>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">



    <!-----------------use--------------------------->

</head>
<body>
<title>MatchaWeeb</title>
<div id="notif">erreur</div>
<h1 class="hdr">MatchaWeeb</h1>
<div id="googleMap"></div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<?php
    require_once($_SERVER["DOCUMENT_ROOT"] .'/config/db_connect.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/miscfuncs.php');

    if (isset($_SESSION['usr']) && isset($_POST['min_age']) && isset($_POST['max_age']) && isset($_POST['min_pop']) && isset($_POST['max_pop']) && isset($_POST['loc']) && isset($_POST['tag']))
    {
        if (is_numeric($_POST['min_age']) && is_numeric($_POST['max_age']) && is_numeric($_POST['min_pop']) && is_numeric($_POST['max_pop']) && is_numeric($_POST['loc']) && is_numeric($_POST['tag'])) {

            $min_age = (int)$_POST['min_age'];
            $max_age = (int)$_POST['max_age'];
            $min_pop = (int)$_POST['min_pop'];
            $max_pop = (int)$_POST['max_pop'];
            $taglimit = (int)$_POST['tag'];
            $loclimit = (int)$_POST['loc'];
            $age = filterAge($db, $min_age, $max_age);
            $pop = filterPop($db, $min_pop, $max_pop);

            //echo 'SELECT uid from profiles WHERE (`birthdate` < ' . $now . '- INTERVAL ' . $max_age .'`birthdate` > ' . $min_age . '<br/>';

            //SEARCH

            $popAgeFilter = array_intersect($age, $pop);
            sort($popAgeFilter);
            $tagFilter = filterTag($db, $popAgeFilter,$taglimit);
            sort($tagFilter);

            // Array contenant la liste d'id des utilisateurs recherchés apres tri

            $users = $tagFilter;
            $end = locateFilter($db, $tagFilter, $loclimit);
            // Exemple d'utilisation

            $i = 0;
            //echo $map;
            echo $slider;
            echo '<div class="container mini-profile">';
            while ($i < count($end)) {
                $currentUser = getUserInfo($db, $end[$i]);
                if (isset($currentUser->username))                            // Pas necessaire en temps normal car l'user existe forcement
                    echo getUserInfo($db, $end[$i])->username . '<br/>';
                $i++;
            }
        }
    }
    else
        header('refresh:0;url=/pages/error401.html');


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
        if ($dist <= $range)
            return 1;
        return 0;
    }

    function locateFilter($db, $arr, $range)
    {
        $res = array();
        $i = 0;
        $j = 0;
        while ($i < count($arr))
        {
            if (isInRange($db, $arr[$i], $range)) {
                $res[$j] = $arr[$i];
                $j++;
            }
            $i++;
        }
        return $res;
    }







