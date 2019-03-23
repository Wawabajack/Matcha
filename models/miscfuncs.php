<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
    require_once ('queryfuncs.php');
    if (!isset($_SESSION))
        session_start();

    function error($code) {
        switch($code) {
            case 1:
                echo 'Nom d\'utilisateur inconnu<br/>';
                break;
            case 2:
                echo 'Mot de passe incorrect<br/>';
                break;
            case 3:
                echo 'Erreur lors du traitement de la requête<br/>';
                break;
            case 4:
                echo 'Nom d\'utilisateur déjà pris<br/>';
                break;
            case 5:
                echo 'Nom d\'utilisateur trop court (4 caractères minimum)<br/>';
                break;
            case 6:
                echo 'Nom trop court<br/>';
                break;
            case 7:
                echo 'Prénom trop court<br/>';
                break;
            case 8:
                echo 'Mot de passe non sécurisé (1 majuscule, 1 chiffre, 1 caractère spécial et 8 lettres minimum)<br/>';
                break;
            case 9: 
                echo 'Nom d\'utilisateur invalide<br/>';
                break;
            case 10:
                echo 'Compte inactif, merci de vérifier vos mails<br/>';
                break;
            case 11:
                echo 'Adresse mail déjà utilisée<br/>';
                break;
            case 12:
                echo 'Le compte est banni<br/>';
                break;

        }
        return 1;

    }

    function logout() {
        unset($_SESSION);
        session_destroy();
        header('refresh:0;url=/index.php');
    }

?>

