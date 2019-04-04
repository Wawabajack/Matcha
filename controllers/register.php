<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/miscfuncs.php');

    if (isset($_POST['register'])) {

        $_SESSION['register'] = 'pending';
        if (postRegCheck($db, $_POST)) {

            // Checking user input
            $_SESSION['error'] = postRegCheck($db, $_POST);
            header('refresh:0;url=../pages/register.php');
        }
        else {

            // Creating new account
            $mailKey = random_str(30);
            addUser($db, ucfirst(strtolower($_POST['username'])), strtoupper($_POST['name']), ucfirst(strtolower($_POST['surname'])), $_POST['mail'], password_hash($_POST['pwd'], 1), $mailKey);
            $mailContent = 'Veuillez cliquer ici : http://www.localhost:8008/controllers/activate.php?key=' . $mailKey . ' afin de confirmer votre inscription';
            $head = '-fwebmaster@MatchaWeeb.com';

            // Sending confirmation mail
            mail($_POST['mail'], 'MatchaWeeb - Inscription', $mailContent, $head);
            $_SESSION['register'] = 'success';
            header('refresh:0;url=../index.php');
        }
    }
    else
        header('refresh:0;url=../pages/error401.html');
?>
