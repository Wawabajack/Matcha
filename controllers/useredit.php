<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');
	if (!isset($_SESSION))
		session_start();
	var_dump($_POST);
	echo '<br/><br/>';
	if (isset($_POST['username']) || isset($_POST['surname']) || isset($_POST['name'])
		|| isset($_POST['gender']) || isset($_POST['mail']) || isset($_POST['age'])
		|| isset($_POST['location']) || isset($_POST['lf']))
	{
		var_dump(checkUserEdit($db, $_POST));
	}



		/** Traiter le form post **/
