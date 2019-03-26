<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
    require_once ('queryfuncs.php');
    if (!isset($_SESSION))
        session_start();

    function error($code) {
        switch($code) {
            case 1:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "nom d\'utilisateur inconnu";</script>'; 
                break;
            case 2:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Mot de passe incorrect";</script>';
                break;
            case 3:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Erreur lors du traitement de la requête";</script>';
                break;
            case 4:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Nom d\'utilisateur déjà pris";</script>';
                break;
            case 5:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Nom d\'utilisateur trop court (4 caractères minimum)";</script>';
                break;
            case 6:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Nom trop court";</script>';
                break;
            case 7:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Prénom trop court";</script>';
                break;
            case 8:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Mot de passe non sécurisé (1 majuscule, 1 chiffre, 1 caractère spécial et 8 lettres minimum)";</script>';               
                 break;
            case 9:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Nom d\'utilisateur invalide";</script>';   
                break;
            case 10:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Compte inactif, merci de vérifier vos mails";</script>';
                break;
            case 11:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Adresse mail déjà utilisée";</script>';
                break;
            case 12:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Le compte est banni";</script>';
                break;
            case 400:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Bad Request<br/>";</script>';
                break;
            case 401:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Unauthorized";</script>';    
                break;
            case 403:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Forbidden";</script>';
                break;
            case 404:
                echo '<script>var erreur = document.getElementById("notif"); erreur.style.display = "block"; erreur.innerHTML = "Not Found<br";</script>';
                break;


        }
        return 1;

    }

    function logout() {
        unset($_SESSION);
        session_destroy();
        header('refresh:0;url=/index.php');
    }

    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

?>

