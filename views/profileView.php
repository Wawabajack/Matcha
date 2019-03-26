<?php
	if (!isset($_SESSION))
		session_start();

	/** Picture & Frame **/

	$startFrame = '<center><div id="frame"><img id="img" src="';
	$endFrame = '"></div></center><br/>';

	/** User infos **/

	$username = '<center>' . ucfirst($_SESSION['usr']->username) . '</center><br/>';
	$gender = 'Genre: ' . $_SESSION['profile']->gender . '<br/>';
	$birthDate = explode("-", $_SESSION['profile']->birthdate);
	$diff = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md") ? ((date("Y")-$birthDate[0])-1):(date("Y")-$birthDate[0]));
	$age = 'Age: '. $diff . '<br/>';
	$location = $_SESSION['profile']->city . ', ' . $_SESSION['profile']->region . ', ' . $_SESSION['profile']->country . '<br/>';
	$popScore = 'Score de popularité: ' . $_SESSION['profile']->popularity . '<br/>';
	$name = 'Nom: ' . $_SESSION['usr']->name . '<br/>';
	$surname = 'Prénom: ' . $_SESSION['usr']->surname . '<br/>';
	$mail = 'Mail: ' . $_SESSION['usr']->mail . '<br/>';