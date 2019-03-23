<?php
    require_once($_SERVER["DOCUMENT_ROOT"] .'/config/db_connect.php');

    function isThere($db, $field, $value) {
        $sql = "SELECT " . $field . " from `users` WHERE " . $field . " = :val";
        $res = $db->prepare($sql);
        $res->bindParam(':val', $value);
        $res->execute();
        $user = $res->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    function getUserInfo($db, $usr) {
        $sql = "SELECT * from `users` WHERE `username` = :usr";
        $res = $db->prepare($sql);
        $res->bindParam(':usr', $usr);
        $res->execute();
        $user = $res->fetch(PDO::FETCH_OBJ);
        return $user;
    }

	function getUserKey($db, $key) {
		$sql = "SELECT `username` from `users` WHERE `mail_key` = :mkey";
		$res = $db->prepare($sql);
		$res->bindParam(':mkey', $key);
		$res->execute();
		$user = $res->fetch(PDO::FETCH_OBJ);
		return $user;
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

    function activateUser($db, $username) {
    	$sql = "UPDATE `users` SET inactive = 0 WHERE username = :usr";
    	$res = $db->prepare($sql);
    	$res->bindParam(':usr', $username);
    	$res->execute();
    }
?>