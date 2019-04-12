<?php
    require_once('views/indexView.php');
    require_once('models/miscfuncs.php');
    require_once('views/mapView.php');
    if (isset($_SESSION['usr']->id))
        require_once('views/ProfileView.php');
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <meta content="Index" name="MatchaWeeb">
    <link href="/css/profile.css" rel="stylesheet" type="text/css">
    <link href="/css/main.css" rel="stylesheet" type="text/css">



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
    if(isset($_POST['unset']))
        unset($_SESSION['search']);
    if(isset($_SESSION['verif']))
    {
        if($_SESSION['verif'] == 0)
            unset($_SESSION['search']);
    }
        //var_dump($_SESSION['verif']);
    if (isset($_SESSION['usr']->id) && !isset($_SESSION['loc']))
    {
        echo '<script>
                function ft_pushInfo(lat, long) { 
                                alert("Localisation en cours, veuillez patienter...");
                                var xhr = new XMLHttpRequest();
                                lat = Number(lat.toFixed(6));
                                long = Number(long.toFixed(6));
                                xhr.open("POST", "controllers/loc.php", true);
                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                xhr.send("lat=" + lat + "&lng=" + long);
                                alert("Localisation terminée !")
                }
                navigator.geolocation.getCurrentPosition(function(location) { ft_pushInfo(location.coords.latitude, location.coords.longitude)})</script>';
        $_SESSION['loc'] = 1;
    }
    if (isset($_POST['home'])) {
        unset($_SESSION['search']);
    }

    /** Register welcome message **/

    if (isset($_SESSION['register'])) {
        echo $_SESSION['register'] == "success" ? $regSuccess : $regFail;
        unset($_SESSION['register']);
    }

    /**  Errors handler **/

    if (isset($_SESSION['error'])) {
        error($_SESSION['error']);
        unset($_SESSION['error']);
    }

    /** User isn't logged **/

    if (!isset($_SESSION['usr'])) {
        echo $loginForm;
    }

    /** User is logged **/

    else {
        echo $menu;
	    if (isset($_SESSION['profile']->id) && isset($_SESSION['prefs']->id))
            echo $profileBtn;
        echo $delogBtn;
    }

    if (isset($_POST['logout']) || (isset($_GET['logout']) && $_GET['logout'] == "1"))
        logout($db);
    
    if (isset($_SESSION['usr']->id)) {

        //Profile and pref check
        if (isset($_SESSION['profile']->id) && isset($_SESSION['prefs']->id) && $_SESSION['profile']->img != '/img/blank.png' && isset($_SESSION['profile']->birthdate))
        {
            $date = new DateTime();
            $birth = new DateTime($_SESSION['profile']->birthdate);
            $age = $date->diff($birth)->y;
            if ($age > 17) {       
                echo $map;
                echo $slider;
                echo '<div class="container mini-profile">';
                //var_dump($_SESSION['search']);
                if (isset($_SESSION['search']) && $_SESSION['search'] != NULL) {
                    //var_dump($_SESSION['results']);
                    $_SESSION['verif'] = 0;
                    $i = 0;
                    if (isset($_SESSION['match'])) {
                        //var_dump($_SESSION['match']);
                        while ($i < $_SESSION['match']) {
                            $isblocked= isBlocked($db, $_SESSION['search'][$i]);
                            $hasblocked = hasBlocked($db, $_SESSION['search'][$i]);
                            if (!((isset($isblocked->value) && $isblocked->value == -1) || (isset($hasblocked->value) && $hasblocked->value == -1))) {
                                $userPrefs = getUserPrefs($db, $_SESSION['search'][$i]);
                                $userProfile = getUserProfile($db, $_SESSION['search'][$i]);
                                $user = getUserInfo($db, $_SESSION['search'][$i]);
                                $date = new DateTime();
                                $birth = new DateTime($userProfile->birthdate);
                                $age = $date->diff($birth)->y . " ans";
                                $loc = $userProfile->city;
                                $gender = $userProfile->gender;
                                $link = '/pages/profile.php?user=' . $user->username;
                                echo $matchLnk . $userProfile->img . $image . $link . $matchName . $user->username . $matchAge . $age . $matchLoc . $loc . $matchGender . $gender . $endFrame;
                            }
                            $i++;
                        }
                    }
                }
            }
        }
        else {
            echo '<center><a href="/pages/profile.php"><button class="btntop">Créer mon profil</button></a></center>';
        }
        echo '</div>';
    }
    
?>
</body>
</html>
