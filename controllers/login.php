<?php
    if (!isset($_SESSION))
        session_start();
    require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/miscfuncs.php');

    if (isset($_POST['usr']) && isset($_POST['pwd'])) {
        if (strCheck($_POST['usr']) && isThere($db, 'username', $_POST['usr'])) {

            /**     Str check ->  existing user ? ->  Retrieve user infos      **/

            if (passwordCheck($db, $_POST['usr'], $_POST['pwd']))
            {
                $_SESSION['usr'] = getUserInfo($db, $_POST['usr']);
                $profile = getUserProfile($db, $_SESSION['usr']->id);
                $prefs = getUserPrefs($db, $_SESSION['usr']->id);
                if (isset($profile->id))
                	$_SESSION['profile'] = $profile;
                if (isset($prefs->id))
                	$_SESSION['prefs'] = $prefs;

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
                else
                	/** User is now logged in **/
                	header('refresh:0;url=/index.php');
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
	    header('refresh:0;url=../pages/error401.html', TRUE, 401);



?>