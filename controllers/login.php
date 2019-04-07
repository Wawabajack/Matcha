<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/miscfuncs.php');

    if (isset($_POST['usr']) && isset($_POST['pwd'])) {
    	$_POST['usr'] =  ucfirst(strtolower($_POST['usr']));
    	$there = isThere($db, 'username', 'users',$_POST['usr'], 'id');
        if (strCheck($_POST['usr']) && isset($there->id)) {

            /**     Str check ->  existing user ? ->  Retrieve user infos      **/

            if (passwordCheck($db, $_POST['usr'], $_POST['pwd']))
            {
                $_SESSION['usr'] = loadUserInfo($db, $_POST['usr']);

	            if ($_SESSION['usr']->warnings > 2) {
	               /** Banned account */

	                $_SESSION['error'] = 12;
		            unset($_SESSION['usr']);
		            header('refresh:0;url=/index.php');
	            }

	            else if ($_SESSION['usr']->inactive == 1) {
                    /** Inactive account **/

                    $_SESSION['error'] = 10;
                    unset($_SESSION['usr']);
                    header('refresh:0;url=/index.php');
                }
                else {
	                /** User is now logged in **/
                    $profile = getUserProfile($db, $_SESSION['usr']->id);
                    $prefs = getUserPrefs($db, $_SESSION['usr']->id);
                    if (isset($profile->id))
                        $_SESSION['profile'] = $profile;
                    if (isset($prefs->id))
                        $_SESSION['prefs'] = $prefs;
                    $now = date("Y-m-d H:i:s");
                    // Updating online profile status
                    mapInit($db, $_SESSION['usr']->id);
                    fieldUpdate($db, $now, $_SESSION['usr']->id, 'lastseen', 'profiles');
                    fieldUpdate($db, 1, $_SESSION['usr']->id, 'online', 'profiles');


/*

                alert("1");
            var lat = location.coords.latitude;
            var lng = location.coords.longitude;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../controllers/loc.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("lat=" + lat + "&lng=" + lng);
            alert("sent");
            alert("lat=" + lat + "&lng=" + lng);
        }
    });

    </script>';*/
                    header('refresh:0;url=/index.php');
                }
            }
            else {
            	    /** Invalid password **/
            	    $_SESSION['error'] = 2;
            	    header('refresh:0;url=/index.php');
            }
        }
        else {
        	/** Unknown user / someone's having fun with Postman **/
            $_SESSION['error'] = 1;
            header('refresh:0;url=/index.php');
        }
    }
    else
	    header('refresh:0;url=../pages/error401.html');



?>