<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');

    
    function executeSqlFile($db){
        $sql = file_get_contents("../matcha_db.sql");
        //var_dump($sql);
        $db->query($sql);
     }

    executeSqlFile($db);
    ?>