<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/views/profileView.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
	if (!isset($_SESSION))
		session_start();
?>

<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
	<meta content="Index" name="MatchaWeeb">
	<link href="/css/profile.css" rel="stylesheet" type="text/css">

	<!------------ Bootstrap includes ------------>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


	<!-----------------use--------------------------->

</head>
<body>
<title>Mon profil</title>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php


	/** User isn't logged **/

	if (!isset($_SESSION['usr']))
		header('refresh:0;url=/pages/error401.html');

	else {

		$image = getProfilePic($db, $_SESSION['usr']->id);
		echo '<center><div id="frame"><img id="img" src="' . $image . '"></div></center>';
	}

	?>