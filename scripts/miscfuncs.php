<?php
    require_once('../config/db_connect.php');
    require_once ('queryfuncs.php');
    if (!isset($_SESSION['usr']))
        session_start();

    function error($code) {
        switch($code) {
            case 1:
                echo '<script>console.log("Nom d\'utilisateur inconnu")</script>';
                break;
            case 2:
                echo '<script>console.log("Mot de passe incorrect")</script>';
                break;
            case 3:
                echo '<script>console.log("Données de formulaire incomplètes")</script>';
                break;
        }
    }

    function logout() {
        session_destroy();
        header('refresh:0;url=/index.php');
    }

?>


