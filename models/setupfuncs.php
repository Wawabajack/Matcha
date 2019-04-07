<?php

	function create_users_table($db) {
		$sql ="SET time_zone = \"+01:00\";
        DROP TABLE IF EXISTS `users`;
        CREATE TABLE `users` (
        `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
        `username` varchar(64) NOT NULL UNIQUE,
        `name` varchar(64) NOT NULL,
        `surname` varchar(64) NOT NULL,
        `mail` varchar(64) NOT NULL UNIQUE,
        `password` varchar(64) NOT NULL,
        `warnings` int(11) NOT NULL,
        `mail_key` varchar(64),
        `admin` int(11),
        `inactive` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		if (!isset($db))
			echo 'Erreur lors de la création de la table utilisateurs, veuillez vérifier la connection avec le serveur SQL' . '<br/>';
		else {
			$res = $db->prepare($sql);
			$res->execute();
			return 1;
		}
		return 0;
	}

	function create_profiles_table($db) {
		$sql = "DROP TABLE IF EXISTS `profiles`;
        CREATE TABLE `profiles` (
        `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
        `uid` int(11) NOT NULL UNIQUE,
        `img` varchar(64) NOT NULL,
        `gender` varchar(64) NOT NULL,
        `birthdate` date NOT NULL,
        `popularity` int(11) NOT NULL,
        `city` varchar(64) NOT NULL,
        `lat` float(10,6) NOT NULL,
        `lng` float(10,6) NOT NULL,
        `lastseen` datetime NOT NULL,
        `online` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		if (!isset($db))
			echo 'Erreur lors de la création de la table des profils, veuillez vérifier la connection avec le serveur SQL' . '<br/>';
		else {
			$res = $db->prepare($sql);
			$res->execute();
			return 1;
		}
		return 0;
	}

	function create_friends_table($db)
	{
		$sql = "DROP TABLE IF EXISTS `friends`;
		CREATE TABLE `friends` (
			`id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
			`source` int(11) NOT NULL,
			`dest` int(11) NOT NULL,
			`value` int(11) NOT NULL
		  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;";
		if (!isset($db))
			echo 'Erreur lors de la création de la table des friends, veuillez vérifier la connection avec le serveur SQL' . '<br/>';
		else {
			$res = $db->prepare($sql);
			$res->execute();
			return 1;
		}
		return 0;
	}

	function create_tags_table($db)
	{
		$sql = "DROP TABLE IF EXISTS `tags`;
		CREATE TABLE `tags` (
			`id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
			`uid` int(11) NOT NULL UNIQUE,
			`tag` varchar(64) NOT NULL
		  	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		if (!isset($db))
			echo 'Erreur lors de la création de la table des tags, veuillez vérifier la connection avec le serveur SQL' . '<br/>';
		else {
			$res = $db->prepare($sql);
			$res->execute();
			return 1;
		}
		return 0;
	}

	function create_preferences_table($db)
	{
		$sql = "DROP TABLE IF EXISTS `preferences`;
            CREATE TABLE `preferences` (
            `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `uid` int(11) NOT NULL UNIQUE,
            `bio` MEDIUMTEXT NOT NULL,
            `gender` varchar(64) NOT NULL,
            `age_min` int(11) NOT NULL,
            `age_max` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		if (!isset($db))
			echo 'Erreur lors de la création de la table des préférences, veuillez vérifier la connection avec le serveur SQL' . '<br/>';
		else {
			$res = $db->prepare($sql);
			$res->execute();
			return 1;
		}
		return 0;
	}

	function add_admin($db)
	{
		$pwd = password_hash('admin', 1);
		$sql = "INSERT INTO `users` (`username`, `name`, `surname`, `mail`, `password`, `warnings`, `mail_key`, `admin`, `inactive`)
                VALUES ('Admin', 'Robichon', 'Baptiste', 'brobicho@student.le-101.fr', :pwd, '0', '0', '1', '0');";
		if (!isset($db))
			return 0;
		$res = $db->prepare($sql);
		$res->bindParam(':pwd', $pwd);
		$res->execute();
		return 1;
	}
