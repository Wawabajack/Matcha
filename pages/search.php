<?php
    require_once($_SERVER["DOCUMENT_ROOT"] .'/config/db_connect.php');

    if (isset($_SESSION['usr']) && isset($_POST['min_age']) && isset($_POST['max_age']) && isset($_POST['min_pop']) && isset($_POST['max_pop']) && isset($_POST['loc']) && isset($_POST['tag']))
    {
        if (is_numeric($_POST['min_age']) && is_numeric($_POST['max_age']) && is_numeric($_POST['min_pop']) && is_numeric($_POST['max_pop']) && is_numeric($_POST['loc']) && is_numeric($_POST['tag'])){

            $min_age = (int)$_POST['min_age'];
            $max_age = (int)$_POST['max_age'];
            $date = date('Y-m-d H:i:s');
            $sql = "SELECT uid FROM `profiles` WHERE `birthdate` < :now - INTERVAL :min_age YEAR AND `birthdate` > :now - INTERVAL :max_age YEAR";
            $res = $db->prepare($sql);
            $res->bindParam(':max_age', $max_age);
            $res->bindParam(':min_age', $min_age);
            $res->bindParam(':now', $date);
            $res->execute();
            $ret = $res->fetchAll(PDO::FETCH_OBJ);
            //echo 'SELECT uid from profiles WHERE (`birthdate` < ' . $now . '- INTERVAL ' . $max_age .'`birthdate` > ' . $min_age . '<br/>';
            var_dump($ret);
            echo 'controller ok';
        }

    }
    else
        header('refresh:0;url=/pages/error401.html');