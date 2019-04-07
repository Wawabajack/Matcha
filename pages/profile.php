<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/miscfuncs.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . '/views/indexView.php');
    $profileV = "";
    $profileS = "";
	if (isset($_SESSION['usr']))
		require_once($_SERVER["DOCUMENT_ROOT"] . '/views/profileView.php');
?>

<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
	<meta content="Index" name="MatchaWeeb">
	<link href="/css/profile.css" rel="stylesheet" type="text/css">

	<!------------ Bootstrap includes ------------>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	<!-----------------use--------------------------->

</head>
<body>
<title>Mon profil</title>
<div id="notif">erreur</div>
<h1 class="hdr">MatchaWeeb</h1>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php

    if (isset($_POST['logout'])) {
		header('refresh:0;url=/index.php?logout=1');
    }

/** User isn't logged **/

if (isset($_SESSION['usr'])){
	echo $menu;
	echo $home;
	echo $delogBtn;
	if (empty($_GET['user']))
	    echo $profileV;

	if (isset($_SESSION['profile']->id) && isset($_SESSION['prefs']->id)
        && isset($_GET['user']) && $_GET['user'] != "" && ctype_alnum($_GET['user']))
    {
        $search = isThere($db, 'username', 'users', $_GET['user'], 'id');
        if (isset($search->id)) {
            $_SESSION['search'] = $search->id;
            require($_SERVER["DOCUMENT_ROOT"] . '/views/searchView.php');
            echo $profileS;
        }
        else
            echo '<script>window.location.replace("/pages/error404.html")</script>';
    }
}



else
	header('refresh:0;url=/pages/error401.html');
?>
</body>
</html>


