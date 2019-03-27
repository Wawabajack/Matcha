<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');

	if (isset($_GET['key']) && keyCheck($db, $_GET['key'])) {
		$user = getUserKey($db, $_GET['key']);
		activateUser($db, $user->id);
		echo '<script>alert("Compte activé");</script>';
		header('refresh:0;url=../index.php');
	}
	else
		header('refresh:0;url=../pages/error400.html');
