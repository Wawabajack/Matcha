<?php
    require_once ("db_connect.php");
    require_once($_SERVER["DOCUMENT_ROOT"] .'/models/setupfuncs.php');

                                    /* TABLES SETUP */

    if (!create_users_table($db) || !create_profiles_table($db) || !create_preferences_table($db))
        echo 'Une ou plusieurs erreurs liées à la connection sont survenues.<br/>';
	else if (!add_admin($db))
		echo 'La création du compte admin a échoué.<br/>';
	else {
		echo 'Tables créées avec succès, retour au menu principal...';
		header('refresh:3;url=../index.php', TRUE, 200);
	}


?>