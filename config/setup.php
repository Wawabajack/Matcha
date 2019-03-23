<?php
    require_once ("db_connect.php");

            /* FUNCTIONS */


    function create_users_table($db) {
       $sql ="SET time_zone = \"+01:00\";
        DROP TABLE IF EXISTS `users`;
        CREATE TABLE `users` (
        `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
        `username` varchar(64) NOT NULL,
        `name` varchar(64) NOT NULL,
        `surname` varchar(64) NOT NULL,
        `mail` varchar(64) NOT NULL,
        `password` varchar(64) NOT NULL,
        `warnings` int(11) NOT NULL,
        `mail_key` varchar(64) NOT NULL,
        `admin` int(11) NOT NULL,
        `inactive` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
       if (!isset($db))
           echo 'Erreur lors de la création de la table utilisateurs, veuillez vérifier la connection avec le serveur SQL' . '<br/>';
       else {
           $res = $db->prepare($sql);
           $res->execute();
           return 1;
       }
    }

    function create_profiles_table($db) {
        $sql = "DROP TABLE IF EXISTS `profiles`;
        CREATE TABLE `profiles` (
        `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
        `gender` varchar(64) NOT NULL,
        `birthdate` date NOT NULL,
        `popularity` int(11) NOT NULL,
        `city` varchar(64) NOT NULL,
        `region` varchar(64) NOT NULL,
        `country` varchar(64) NOT NULL,
        `lastseen` datetime NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        if (!isset($db))
            echo 'Erreur lors de la création de la table des profils, veuillez vérifier la connection avec le serveur SQL' . '<br/>';
        else {
            $res = $db->prepare($sql);
            $res->execute();
            return 1;
        }
    }

    function create_preferences_table($db)
    {
        $sql = "DROP TABLE IF EXISTS `preferences`;
            CREATE TABLE `preferences` (
            `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `notifs` int(11) NOT NULL,
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
    }


                        /* FUNCTIONS */




                        /* TABLES SETUP */




    if (!create_users_table($db) || !create_profiles_table($db) || !create_preferences_table($db))
        echo 'Une ou plusieurs erreurs liées à la connection sont survenues.';
    else {
        echo 'Tables créées avec succès, retour au menu principal...';
        header('refresh:3;url=../index.php', TRUE, 200);
    }




?>