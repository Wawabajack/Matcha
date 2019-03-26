<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/views/profileView.php');
	if (!isset($_SESSION))
		session_start();