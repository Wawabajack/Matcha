<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');
	if (!isset($_SESSION))
		session_start();

	$arr = array("username", "surname", "name", "gender", "mail", "birth", "location", "lf");
	$elems = array();
	foreach ($arr as $val) {
		$post = trim($_POST[$val]);
		if (isset($_POST[$val]) && !empty($post))
			$elems[$val] = $post;
	}
	if (isset($elems) && checkUserEdit($post)) {
		/** Traiter le form post **/
		var_dump($elems);
		profileUpdate($db, $elems);
	}
	else
		header('refresh:20;url=/pages/profile.php');


