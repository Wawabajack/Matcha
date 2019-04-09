<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');
    //var_dump($_POST['mail']);
    if (isset($_POST['mail'])/* && filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL) === $_POST['mail']*/)
    {
        $user = isThere($db, 'mail', 'users', $_POST['mail'], '*');
        if (isset($user->mail))
        {
            $str = random_str(30);
            $sql = "UPDATE `users` SET `forgot_key` = :val WHERE `id` = :uid";
            $res = $db->prepare($sql);
            $res->bindParam(':uid', $user->id);
            $res->bindParam(':val', $str);
            $res->execute();
            $mailContent = 'Veuillez cliquer ici : http://www.localhost:8008/controllers/forgot.php?key=' . $str . ' afin que nous puissions vous envoyer un nouveau mot de passe.';
            $head = '-fwebmaster@MatchaWeeb.com';
            mail($user->mail, 'MatchaWeeb - Vérification de sécurité', $mailContent, $head);
            echo 'Mail envoyé, retour au menu principal...';
            header('refresh:3;url=/index.php');
        }
        else//echo "3";
            header('refresh:0;url=/pages/error404.html');
    }
    else if (isset($_GET['key']) && ctype_alnum($_GET['key']))
    {
        //echo '<script>document.getElementsByClassName("container")[0].enabled = 0;</script>';
        $key = isThere($db, 'forgot_key', 'users', $_GET['key'], '*');
        if (isset($key->forgot_key)) {
            $str = random_str(10);
            $new = password_hash($str, 1);
            $sql = "UPDATE `users` SET `password` = :pwd WHERE `id` = :uid";
            $res = $db->prepare($sql);
            $res->bindParam(':pwd', $new);
            $res->bindParam(':uid', $key->id);
            $res->execute();
            resetForgotKey($db, $key->id);
            $mailContent = 'Voici votre nouveau mot de passe, ne le communiquez à personne : ' . $str;
            $head = '-fwebmaster@MatchaWeeb.com';
            mail($key->mail, 'MatchaWeeb - Nouveau mot de passe', $mailContent, $head);
            echo 'Mail envoyé, retour au menu principal...';
            header('refresh:3;url=/index.php?logout=1');
        }
        else
            header('refresh:0;url=/pages/error401.html');
            //echo "2";
    }
    else
        //header('refresh:0;url=/pages/error401.html');
        echo "1";