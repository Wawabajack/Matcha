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
            $mailKey = base64_encode(openssl_random_pseudo_bytes(15));
            addUser($db, $_POST['username'], $_POST['name'], $_POST['surname'], $_POST['mail'], password_hash($_POST['pwd'], 1), $mailKey);
            $mailContent = 'Veuillez cliquer <a href="http://www.localhost:8008/controllers/activate.php?key=' . $mailKey . '"> ici </a> afin de confirmer votre inscription\n';
            $head = 'fwebmaster@bromagru.com';

            // Sending confirmation mail
            mail($_POST['mail'], 'MatchaWeeb - Inscription', $mailContent, $head);
            unset($_SESSION['register']);
            header('refresh:0;url=../index.php');
        }
    }
    else
        header('refresh:0;url=../pages/error401.html', TRUE, 401);

?>
