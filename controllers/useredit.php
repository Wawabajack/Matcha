<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');

	if (isset($_SESSION['usr']) && ((isset($_POST['username']) || isset($_POST['surname']) || isset($_POST['name'])
		|| isset($_POST['gender']) || isset($_POST['mail']) || isset($_POST['age'])
		|| isset($_POST['location']) || isset($_POST['lf']) || isset($_POST['file']) || isset($_POST['bio']) || isset($_POST['oldpwd']) || isset($_POST['newpwd']))
            && profileUpdate($db, checkUserEdit($db, $_POST), $_SESSION['usr']->id, $_FILES))) // Checking infos then pushing profile infos to database
	{
		// Reloading session
        $_SESSION['usr'] = getUserInfo($db, $_SESSION['usr']->id);
		$profile = getUserProfile($db, $_SESSION['usr']->id);
		$prefs = getUserPrefs($db, $_SESSION['usr']->id);
		if (isset($prefs->uid))
			$_SESSION['prefs'] = $prefs;
		if (isset($profile->uid))
			$_SESSION['profile'] = $profile;
		//header('refresh:0;url=/pages/profile.php');
	}
	else
		header('refresh:0;url=/pages/profile.php');

