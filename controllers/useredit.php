<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');
	if (!isset($_SESSION))
		session_start();

	if (isset($_SESSION['usr']) && ((isset($_POST['username']) || isset($_POST['surname']) || isset($_POST['name'])
		|| isset($_POST['gender']) || isset($_POST['mail']) || isset($_POST['age'])
		|| isset($_POST['location']) || isset($_POST['lf'])) && checkUserEdit($_POST)))
	{
		$trimmed = checkUserEdit($_POST);
		profileUpdate($db, $trimmed, $_SESSION['usr']->id);
	}

	else
		header('refresh:20;url=/pages/profile.php');

