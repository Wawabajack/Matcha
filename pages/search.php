<?php
    require_once($_SERVER["DOCUMENT_ROOT"] .'/config/db_connect.php');

    if (isset($_SESSION['usr']) && isset($_POST['min_age']) && isset($_POST['max_age']) && isset($_POST['min_pop']) && isset($_POST['max_pop']) && isset($_POST['loc']) && isset($_POST['tag']))
    {
        if (is_numeric($_POST['min_age']) && is_numeric($_POST['max_age']) && is_numeric($_POST['min_pop']) && is_numeric($_POST['max_pop']) && is_numeric($_POST['loc']) && is_numeric($_POST['tag'])) {

            $min_age = (int)$_POST['min_age'];
            $max_age = (int)$_POST['max_age'];
            $min_pop = (int)$_POST['min_pop'];
            $max_pop = (int)$_POST['max_pop'];
            $taglimit = (int)$_POST['tag'];
            $loclimit = (int)$_POST['loc'];
            $age = filterAge($db, $min_age, $max_age);
            $pop = filterPop($db, $min_pop, $max_pop);

            //echo 'SELECT uid from profiles WHERE (`birthdate` < ' . $now . '- INTERVAL ' . $max_age .'`birthdate` > ' . $min_age . '<br/>';

            //SEARCH
            var_dump($age);
            echo '<br/>';
            var_dump($pop);
            echo '<br/>';
            echo '<br/>';
            $popAgeFilter = array_intersect($age, $pop);
            sort($popAgeFilter);
            $tagFilter = filterTag($db, $popAgeFilter);
            sort($tagFilter);
            var_dump($tagFilter);
        }
    }
    else
        header('refresh:0;url=/pages/error401.html');

    function filterAge($db, $minAge, $maxAge) {
        $date = date('Y-m-d H:i:s');
        $sql = "SELECT uid FROM `profiles` WHERE `birthdate` <= :now - INTERVAL :min_age YEAR AND `birthdate` >= :now - INTERVAL :max_age YEAR AND `uid` != :me";
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

    function makeArray($ret) {
        $i = 0;
        $res = array();
        while ($i < count($ret)) {
            if (isset($res[$i]->uid))
                $res[$i] = $ret[$i]->uid;
            $i++;
        }
            return $res;
    }

    function filterTag($db, $results)
    {
        $i = 0;
        $res = array();
        //while ($i < count($results)) {
            $tags = getTags($db, $results[$i]);
            if (isset($tags->tag))
                $res[$i] = $tags->tag;
      //      $i++;
       // }
        return $res;
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