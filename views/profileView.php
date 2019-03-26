<?php
	if (!isset($_SESSION))
		session_start();
	$startFrame = '<center><div id="frame"><img id="img" src="';
	$endFrame = '"></div></center><br/>';
	$username = '<center>' . ucfirst($_SESSION['usr']->username) . '</center><br/>';
