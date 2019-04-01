<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');
	if (!isset($_SESSION))
		session_start();

	if (isset($_SESSION['usr']) && ((isset($_POST['username']) || isset($_POST['surname']) || isset($_POST['name'])
		|| isset($_POST['gender']) || isset($_POST['mail']) || isset($_POST['age'])
		|| isset($_POST['location']) || isset($_POST['lf'])) && profileUpdate($db, checkUserEdit($_POST), $_SESSION['usr']->id))) // Checking infos then pushing profile infos to database
	{

		// Reloading session
		$_SESSION['usr'] = getUserInfo($db, $_SESSION['usr']->id);
		$profile = getUserProfile($db, $_SESSION['usr']->id);
		$prefs = getUserPrefs($db, $_SESSION['usr']->id);
		if (isset($prefs->uid))
			$_SESSION['prefs'] = $prefs;
		header('refresh:0;url=/pages/profile.php');
	}
	else
		header('refresh:0;url=/pages/profile.php');

