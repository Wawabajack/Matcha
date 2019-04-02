<?php
    require_once($_SERVER["DOCUMENT_ROOT"] .'/config/db_connect.php');

    function isThere($db, $field, $table, $value, $select) {
    	$sql = "SELECT " . $select . " from ". $table ." WHERE " . $field . " = :val";
    	$res = $db->prepare($sql);
        $res->bindParam(':val', $value);
        $res->execute();
        $user = $res->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    function getUserInfo($db, $uid) {
        $sql = "SELECT * from `users` WHERE `id` = :uid";
        $res = $db->prepare($sql);
        $res->bindParam(':uid', $uid);
        $res->execute();
        $user = $res->fetch(PDO::FETCH_OBJ);
        return $user;
    }

	function loadUserInfo($db, $usr) {
		$sql = "SELECT * from `users` WHERE `username` = :usr";
		$res = $db->prepare($sql);
		$res->bindParam(':usr', $usr);
		$res->execute();
		$user = $res->fetch(PDO::FETCH_OBJ);
		return $user;
	}

	function getUserKey($db, $key) {
		$sql = "SELECT `id` from `users` WHERE `mail_key` = :mkey";
		$res = $db->prepare($sql);
		$res->bindParam(':mkey', $key);
		$res->execute();
		$user = $res->fetch(PDO::FETCH_OBJ);
		return $user;
	}

	function createProfile($db, $uid) {
		$sql = "INSERT INTO `profiles` (`uid`, `img`) VALUES (:uid, '/img/404.png')";
		$res = $db->prepare($sql);
		$res->bindParam(':uid', $uid);
		$res->execute();
	}

	function createPrefs($db, $uid) {
		$sql = "INSERT INTO `preferences` (`uid`) VALUES (:uid)";
		$res = $db->prepare($sql);
		$res->bindParam(':uid', $uid);
		$res->execute();
	}

    function addUser($db, $username, $name, $surname, $mail, $pwd, $mailKey) {
        $sql = "INSERT INTO `users` (`username`, `name`, `surname`, `mail`, `password`, `warnings`, `mail_key`, `admin`, `inactive`)
                VALUES (:usr, :nom, :surname, :mail, :pwd, '0', :mail_key, '0', '1')";
        $res = $db->prepare($sql);
        $res->bindParam(':usr', $username);
        $res->bindParam(':nom', $name);
        $res->bindParam(':surname', $surname);
        $res->bindParam(':mail', $mail);
        $res->bindParam(':pwd', $pwd);
        $res->bindParam(':mail_key', $mailKey);
        $res->execute();
    }

    function activateUser($db, $uid) {
    	$sql = "UPDATE `users` SET inactive = 0 WHERE `id` = :uid";
    	$res = $db->prepare($sql);
    	$res->bindParam(':uid', $uid);
    	$res->execute();
	    $sql = "UPDATE `users` SET mail_key = 0 WHERE `id` = :uid";
	    $res = $db->prepare($sql);
	    $res->bindParam(':uid', $uid);
	    $res->execute();

    }

    function getUserProfile($db, $uid) {
		$sql = "SELECT * FROM `profiles` WHERE `id` = :uid";
	    $res = $db->prepare($sql);
	    $res->bindParam(':uid', $uid);
	    $res->execute();
	    $user = $res->fetch(PDO::FETCH_OBJ);
	    return $user;
	}
	
	function getUsermap($db) {
		$sql = "SELECT * FROM markers WHERE 1";
		$res = $db->prepare($sql);
		//$res->bindParam(':uid', $uid);
		$res->execute();
		//$user = $res->fetch(PDO::FETCH_OBJ);
		return $res;
	}

    function getUserPrefs($db, $uid) {
		$sql = "SELECT * FROM `preferences` WHERE `id` = :uid";
		$res = $db->prepare($sql);
		$res->bindParam(':uid', $uid);
		$res->execute();
		$user = $res->fetch(PDO::FETCH_OBJ);
		return $user;
	}

	function fieldUpdate($db, $val, $uid, $field, $table) {
    	if ($table == "users")
    		$id = "`id`";
    	else
    		$id = "`uid`";
    	$sql = "UPDATE `" . $table . "` SET `" . $field . "` = :val WHERE " . $id . " = :uid";
    	$res = $db->prepare($sql);
		$res->bindParam(':val', $val);
		$res->bindParam(':uid', $uid);
		$res->execute();
		$sql = "UPDATE `" . $table . "` SET `" . $field . "` = " . $val . " WHERE " . $id . " = " . $uid;
		echo $sql . '<br/>';
		return 1;
    }
	/*
	function locupdate($db, $uid) {
		$sql = "UPDATE 'marker' SET 'lat' = $lat, 'lng' = $lng WHERE uid = $uid
		$res = $db->prepare($sql);
		$res->bindParam(':uid', $uid);
		$res->execute();
		$user = $res->fetch(PDO::FETCH_OBJ);
		return $user;
	}
	*/
?>