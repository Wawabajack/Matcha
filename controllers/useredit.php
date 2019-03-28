<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');
	if (!isset($_SESSION))
		session_start();
	var_dump($_POST);
	echo '<br/><br/>';
	$arr = array("username", "surname", "name", "gender", "mail", "birth", "location", "lf");
	$elem = 0;
	foreach ($arr as $val)
		if (isset($_POST[$val]) && trim($_POST[$val]) && !empty($_POST[$val]))
			$elem++;
	if ($elem)
		var_dump(checkUserEdit($db, $_POST));
	else
		header('refresh:0;url=/pages/profile.php');


		/** Traiter le form post **/
