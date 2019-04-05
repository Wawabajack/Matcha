<?php
    require_once($_SERVER["DOCUMENT_ROOT"] .'/config/db_connect.php');

    if (isset($_SESSION['usr']) && isset($_POST['min_age']) && isset($_POST['max_age']) && isset($_POST['min_pop']) && isset($_POST['max_pop']) && isset($_POST['loc']) && isset($_POST['tag']))
    {
        if (is_numeric($_POST['min_age']) && is_numeric($_POST['max_age']) && is_numeric($_POST['min_pop']) && is_numeric($_POST['max_pop']) && is_numeric($_POST['loc']) && is_numeric($_POST['tag'])){
            $date = (int)date('Y');
            $min_age = $date - $_POST['min_age'];
            $max_age = $date - $_POST['max_age'];

        $sql = "SELECT uid FROM `profiles` WHERE `birthdate` < :max_age AND `birthdate` > :min_age";
        $res = $db->prepare($sql);
        $res->bindParam(':max_age', $max_age);
        $res->bindParam(':min_age', $min_age);
        $res->execute();
        var_dump($min_age);
        var_dump($max_age);
        $ret = $res->fetch(PDO::FETCH_OBJ);
        echo 'SELECT uid from profiles WHERE `birthdate` < ' .$max_age . ' AND `birthdate` > ' . $min_age . '<br/>';
        echo 'controller ok';
        }

    }
    else
        header('refresh:0;url=/pages/error401.html');