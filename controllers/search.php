<?php
<<<<<<< HEAD
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
            $end = locateFilter($db, $tagFilter, $loclimit);
            // Exemple d'utilisation

            $i = 0;
            while ($i < count($end)) {
                $currentUser = getUserInfo($db, $end[$i]);
                if (isset($currentUser->username))                            // Pas necessaire en temps normal car l'user existe forcement
                    echo getUserInfo($db, $end[$i])->username . '<br/>';
                $i++;
            }
        }
    }
    else
        header('refresh:0;url=/pages/error401.html');


    function dist($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $rad = M_PI / 180;
        //Calculate distance from latitude and longitude
        $theta = $longitudeFrom - $longitudeTo;
        $dist = sin($latitudeFrom * $rad)
            * sin($latitudeTo * $rad) +  cos($latitudeFrom * $rad)
            * cos($latitudeTo * $rad) * cos($theta * $rad);

        return acos($dist) / $rad * 60 *  1.853;
    }

    function isInRange($db, $uid, $range)
    {
        $user = getUserProfile($db, $uid);
        $cmpLat = $user->lat;
        $cmplng = $user->lng;
        $myLat = $_SESSION['profile']->lat;
        $myLng = $_SESSION['profile']->lng;
        $dist = dist($myLat, $myLng, $cmpLat, $cmplng);
        if ($dist <= $range)
            return 1;
        return 0;
    }

    function locateFilter($db, $arr, $range)
    {
        $res = array();
        $i = 0;
        $j = 0;
        while ($i < count($arr))
        {
            if (isInRange($db, $arr[$i], $range)) {
                $res[$j] = $arr[$i];
                $j++;
            }
            $i++;
        }
        return $res;
    }

=======
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
			var_dump($tagFilter);
			sort($tagFilter);

			// Array contenant la liste d'id des utilisateurs recherchés apres tri

			$users = $tagFilter;
			$end = locateFilter($db, $tagFilter, $loclimit);
			// Exemple d'utilisation
			$i = 0;
			while ($i < count($end)) {
				$currentUser = getUserInfo($db, $end[$i]);
				if (isset($currentUser->username))                            // Pas necessaire en temps normal car l'user existe forcement
					echo getUserInfo($db, $end[$i])->username . '<br/>';
				$i++;
			}
		}
	}
	else
		header('refresh:0;url=/pages/error401.html');

	function dist($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
	{
		$rad = M_PI / 180;
		//Calculate distance from latitude and longitude
		$theta = $longitudeFrom - $longitudeTo;
		$dist = sin($latitudeFrom * $rad)
			* sin($latitudeTo * $rad) +  cos($latitudeFrom * $rad)
			* cos($latitudeTo * $rad) * cos($theta * $rad);
		return acos($dist) / $rad * 60 *  1.853;
	}

	function isInRange($db, $uid, $range)
	{
		$user = getUserProfile($db, $uid);
		$cmpLat = $user->lat;
		$cmplng = $user->lng;
		$myLat = $_SESSION['profile']->lat;
		$myLng = $_SESSION['profile']->lng;
		$dist = dist($myLat, $myLng, $cmpLat, $cmplng);
		if ($dist <= $range)
			return 1;
		return 0;
	}

	function locateFilter($db, $arr, $range)
	{
		$res = array();
		$i = 0;
		$j = 0;
		while ($i < count($arr)) {
			if (isInRange($db, $arr[$i], $range)) {
				$res[$j] = $arr[$i];
				$j++;
			}
			$i++;
		}
		return $res;
	}
>>>>>>> 967e7e0f37f7d96a487753ba7b6fcda2468feacc






