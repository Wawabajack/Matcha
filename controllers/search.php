<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
	
	if (isset($_POST['match']) && isset($_SESSION['usr']) && isset($_SESSION['prefs']->id) && isset($_SESSION['profile']->id))
		{
			$match = match($db);
			$res = array();
			$i = 0;
			//ar_dump($match);
			//var_dump(count($match['dist']));
			while ($i < count($match['dist']))
			{
				$res[$i] = $match['uid'][$i];
				$i++;
			}
			//var_dump($res);
			
			//unset($_SESSION['search']);
			$_SESSION['search'] = $res;
			
			count($res) > 3 ? $_SESSION['match'] = 3 : $_SESSION['match'] = count($res);
						//var_dump($res);
			$_SESSION['verif'] = 1;
			header('refresh:0;url=/index.php');
		}
	
	else if (isset($_SESSION['usr']) && isset($_SESSION['prefs']->id) && isset($_SESSION['profile']->id) && isset($_POST['min_age']) && isset($_POST['max_age']) && isset($_POST['min_pop']) && isset($_POST['max_pop']) && isset($_POST['loc']) && isset($_POST['tag']))
	{
		if (is_numeric($_POST['min_age']) && is_numeric($_POST['max_age']) && is_numeric($_POST['min_pop']) && is_numeric($_POST['max_pop']) && is_numeric($_POST['loc']) && is_numeric($_POST['tag'])) {
			$min_age = (int)$_POST['min_age'];
			$max_age = (int)$_POST['max_age'];
			$min_pop = (int)$_POST['min_pop'];
			$max_pop = (int)$_POST['max_pop'];
			$taglimit = (int)$_POST['tag'];
			$loclimit = (int)$_POST['loc'];
			$_SESSION['search'] = search($db, $min_age, $max_age, $min_pop, $max_pop, $taglimit, $loclimit);
			$_SESSION['match'] = count($_SESSION['search'] );
			$_SESSION['verif'] = 1;
			//var_dump($_SESSION['results']);
			header('refresh:0;url=/index.php');
			//echo 'SELECT uid from profiles WHERE (`birthdate` < ' . $now . '- INTERVAL ' . $max_age .'`birthdate` > ' . $min_age . '<br/>';
			//SEARCH

			//var_dump($popAgeFilter);

			// Array contenant la liste d'id des utilisateurs recherchés apres tri

            //var_dump($res);
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
