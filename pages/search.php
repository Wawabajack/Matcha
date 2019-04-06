<?php
    require_once($_SERVER["DOCUMENT_ROOT"] .'/config/db_connect.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/miscfuncs.php');

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

            $popAgeFilter = array_intersect($age, $pop);
            sort($popAgeFilter);
            $tagFilter = filterTag($db, $popAgeFilter,$taglimit);
            sort($tagFilter);

            // Array contenant la liste d'id des utilisateurs recherchés apres tri

            $users = $tagFilter;

            // Exemple d'utilisation

            $i = 0;
            while ($i < count($users)) {
                $currentUser = getUserInfo($db, $users[$i]);
                if (isset($currentUser->username))                            // Pas necessaire en temps normal car l'user existe forcement
                    echo getUserInfo($db, $users[$i])->username . '<br/>';
                $i++;
            }
        }
    }
    else
        header('refresh:0;url=/pages/error401.html');










