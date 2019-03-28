<?php
    if (!isset($_SESSION))
        session_start();
    require_once('views/indexView.php');
    require_once('models/miscfuncs.php');
    require_once('views/ProfileView.php')
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <meta content="Index" name="MatchaWeeb">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/profile.css" rel="stylesheet" type="text/css">


    <!------------ Bootstrap includes ------------>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">



    <!-----------------use--------------------------->

</head>
<body>
<title>MatchaWeeb</title>
<div id="notif">erreur</div>
<h1 class="hdr">MatchaWeeb</h1>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<?php


    /** Register welcome message **/

    if (isset($_SESSION['register']) && $_SESSION['register'] == 'success')
        echo $regSuccess;

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
        echo '<div id="nav-a">';
        echo '<ul>';
        echo '<li>';
        if (!isset($_SESSION['profile']->id)){
            echo $createProfileBtn;
            echo '</li>';
        }
        else{
            echo $profileBtn;
            echo '</li>';
        }
        echo '<li>';
        echo $delogBtn;
        echo '</li>';
        echo '</ul>';
        echo '</div>';
    }

    if (isset($_POST['logout'])) {
        logout(); }
    
    $i = 1;
    echo ' <div class="container mini-profile">';
    while($i <= 10){
        $i++;
        echo $match;
    }
    echo '</div>';
?>
</body>
</html>
