<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');
	if (isset($_SESSION['usr']) && isset($_POST['min_age']) && isset($_POST['max_age']) && isset($_POST['min_pop']) && isset($_POST['max_pop']) && isset($_POST['loc']) && isset($_POST['tag']))
	{
		if (is_numeric($_POST['min_age']) && is_numeric($_POST['max_age']) && is_numeric($_POST['min_pop']) && is_numeric($_POST['max_pop']) && is_numeric($_POST['loc']) && is_numeric($_POST['tag'])) {
			$min_age = (int)$_POST['min_age'];
			$max_age = (int)$_POST['max_age'];
			$min_pop = (int)$_POST['min_pop'];
			$max_pop = (int)$_POST['max_pop'];
			$taglimit = (int)$_POST['tag'];
			$loclimit = (int)$_POST['loc'];
			$_SESSION['results'] = search($db, $min_age, $max_age, $min_pop, $max_pop, $taglimit, $loclimit);
			header('refresh:0;url=/index.php');
			//echo 'SELECT uid from profiles WHERE (`birthdate` < ' . $now . '- INTERVAL ' . $max_age .'`birthdate` > ' . $min_age . '<br/>';
			//SEARCH

			//var_dump($popAgeFilter);

			// Array contenant la liste d'id des utilisateurs recherchés apres tri

            var_dump($res);
			// Exemple d'utilisation
			/*$i = 0;
			while ($i < count($end)) {
				$currentUser = getUserInfo($db, $end[$i]);
				if (isset($currentUser->username))                            // Pas necessaire en temps normal car l'user existe forcement
					echo getUserInfo($db, $end[$i])->username . '<br/>';
				$i++;
			}*/
		}
	}
	else
		header('refresh:0;url=/pages/error401.html');

	function search($db, $minAge, $maxAge, $minPop, $maxPop, $tagReq, $locLimit)
    {
        $age = filterAge($db, $minAge, $maxAge);
        $pop = filterPop($db, $minPop, $maxPop);
        $popAgeFilter = array_intersect($age, $pop);
        sort($popAgeFilter);
        $tagFilter = filterTag($db, $popAgeFilter,$tagReq);
        sort($tagFilter);
        $locate = locateFilter($db, $tagFilter, $locLimit);
        $gender = genderFilter($db, $locate);
        $res = blockFilter($db, $gender);
        sort($res);
        return $res;
    }

	function blockFilter($db, $arr)
    {
        sort($arr);
	    $res = array();
	    $i = 0;
	    while ($i < count($arr))
        {
            $user = isBlocked($db, $arr[$i]);
            $me = hasBlocked($db, $arr[$i]);
            if ((!isset($user->value) || $user->value != -1) && (!isset($me->value) || $me->value != -1))
                $res[$i] = $arr[$i];
            $i++;
        }
        return $res;
    }

	function isCompatible($db, $match, $me)
    {
        $otherprofile = getUserProfile($db, $match);
        $otherprefs = getUserPrefs($db, $match);
        $myprofile = getUserProfile($db, $me);
        $myprefs = getUserPrefs($db, $me);
        if (isset($myprefs->gender) && isset($myprofile->gender)
            && isset($otherprefs->gender) && isset($otherprofile->gender) && $myprefs->gender == $otherprofile->gender)
            return 1;
        return 0;
    }

	function genderFilter($db, $locate)
    {
        $res = array();
        $i = 0;
        while ($i < count($locate))
        {
            if (isCompatible($db, $locate[$i], $_SESSION['usr']->id))
                $res[$i] = $locate[$i];
            $i++;
        }
        return $res;
    }

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
		//echo 'dist: '. $dist . '<br/>' . 'range: '. $range. '<br/><br/>';
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
