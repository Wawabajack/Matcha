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

    function getUsertag($db, $uid) {
        $sql = "SELECT * from `tags` WHERE `id` = :uid";
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

	function hasBlocked ($db, $usr) {
        $sql = "SELECT `value` from `friends` WHERE `source` = :uid AND `dest` = :me";
        $res = $db->prepare($sql);
        $res->bindParam(':uid', $usr);
        $res->bindParam(':me', $_SESSION['usr']->id);
        $res->execute();
        $user = $res->fetch(PDO::FETCH_OBJ);
        return $user;
    }

	function isBlocked($db, $usr) {
        $sql = "SELECT `value` from `friends` WHERE `source` = :me AND `dest` = :uid";
        $res = $db->prepare($sql);
        $res->bindParam(':uid', $usr);
        $res->bindParam(':me', $_SESSION['usr']->id);
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
		$sql = "INSERT INTO `profiles` (`uid`, `img`, `gender`) VALUES (:uid, '/img/blank.png', 'N')";
		$res = $db->prepare($sql);
		$res->bindParam(':uid', $uid);
		$res->execute();
	}

	function createPrefs($db, $uid) {
		$sql = "INSERT INTO `preferences` (`uid`, `gender`) VALUES (:uid, 'N')";
		$res = $db->prepare($sql);
		$res->bindParam(':uid', $uid);
		$res->execute();
	}

    function filterAge($db, $minAge, $maxAge) {
        $date = date('Y-m-d H:i:s');
        $sql = "SELECT uid FROM `profiles` WHERE `birthdate` <= :now - INTERVAL :min_age YEAR AND `birthdate` >= :now - INTERVAL :max_age + 1 YEAR AND `uid` != :me";
        $res = $db->prepare($sql);
        $res->bindParam(':max_age', $maxAge);
        $res->bindParam(':min_age', $minAge);
        $res->bindParam(':now', $date);
        $res->bindParam(':me', $_SESSION['usr']->id);
        $res->execute();
        $ret = $res->fetchAll(PDO::FETCH_OBJ);
        return makeArray($ret);
    }

    function filterPop($db, $minPop, $maxPop) {
        $sql = "SELECT uid FROM `profiles` WHERE `popularity` >= :minPop AND `popularity` <= :maxPop AND `uid` != :me";
        $res = $db->prepare($sql);
        $res->bindParam(':minPop', $minPop);
        $res->bindParam(':maxPop', $maxPop);
        $res->bindParam(':me', $_SESSION['usr']->id);
        $res->execute();
        $ret = $res->fetchAll(PDO::FETCH_OBJ);
        return makeArray($ret);
    }

    function getTags($db, $uid)
    {
        $sql = 'SELECT `tag` FROM `tags` WHERE `uid` = :uid';
        $res = $db->prepare($sql);
        $res->bindParam(':uid', $uid);
        $res->execute();
        $ret = $res->fetch(PDO::FETCH_OBJ);
        return ($ret);
    }

    function resetForgotKey($db, $uid)
    {
        $sql = "UPDATE `users` SET `forgot_key` = 0 WHERE `id` = :uid";
        $res = $db->prepare($sql);
        $res->bindParam(':uid', $uid);
        $res->execute();
    }

    function addUser($db, $username, $name, $surname, $mail, $pwd, $mailKey) {
        $sql = "INSERT INTO `users` (`username`, `name`, `surname`, `mail`, `password`, `warnings`, `mail_key`, `forgot_key`, `admin`, `inactive`)
                VALUES (:usr, :nom, :surname, :mail, :pwd, '0', :mail_key, '0','0','1')";
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

    function addPop($db, $uid, $val)
    {
        $v = getUserProfile($db, $_SESSION['search'])->popularity + $val;
        $sql = "UPDATE `profiles` SET `popularity` = :val WHERE `uid` = :uid";
        $res = $db->prepare($sql);
        $res->bindParam(':uid', $uid);
        $res->bindParam(':val', $v);
        $res->execute();
    }

    function subPop($db, $uid, $val)
    {
        $v = getUserProfile($db, $_SESSION['search'])->popularity - $val;
        $sql = "UPDATE `profiles` SET `popularity` = :val WHERE `uid` = :uid";
        $res = $db->prepare($sql);
        $res->bindParam(':uid', $uid);
        $res->bindParam(':val', $v);
        $res->execute();
    }

    function insertFriend($db, $uid, $val)
    {
        $sql = "INSERT INTO `friends` (`source`, `dest`, `value`) VALUES (:me, :uid, :val)";
        $res = $db->prepare($sql);
        $res->bindParam(':me', $_SESSION['usr']->id);
        $res->bindParam(':uid', $uid);
        $res->bindParam(':val', $val);
        $res->execute();
    }

    function updateFriend($db, $uid, $val)
    {
        $sql = "UPDATE `friends` SET `value` = :val WHERE `source` = :me AND `dest` = :uid";
        $res = $db->prepare($sql);
        $res->bindParam(':me', $_SESSION['usr']->id);
        $res->bindParam(':uid', $uid);
        $res->bindParam(':val', $val);
        $res->execute();
    }

    function getUserProfile($db, $uid) {
		$sql = "SELECT * FROM `profiles` WHERE `uid` = :uid";
	    $res = $db->prepare($sql);
	    $res->bindParam(':uid', $uid);
	    $res->execute();
	    $user = $res->fetch(PDO::FETCH_OBJ);
	    return $user;
	}

	function getUsermap($db) {
		$sql = "SELECT * FROM `profiles`";
		$res = $db->prepare($sql);
		$res->execute();
		return $res;
	}

    function getUserPrefs($db, $uid) {
		$sql = "SELECT * FROM `preferences` WHERE `uid` = :uid";
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
		// DEBUG -- $sql = "UPDATE `" . $table . "` SET `" . $field . "` = " . $val . " WHERE " . $id . " = " . $uid;
		//       -- echo $sql;
		return 1;
    }
	
	function locupdate($db, $uid, $lat, $lng) {
		$sql = "UPDATE `profiles` SET `lat` = :lat, `lng` = :lng WHERE `uid` = :uid";
		$res = $db->prepare($sql);
		$res->bindParam(':uid', $uid);
        $res->bindParam(':lat', $lat);
        $res->bindParam(':lng', $lng);
		$res->execute();
		return 1;
	}



?>