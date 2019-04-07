<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');

    if (isset($_POST['lat']) && isset($_POST['lng']) && is_numeric($_POST['lat']) && is_numeric($_POST['lng']))
    {
        $lat = floatval($_POST['lat']);
        $lng = floatval($_POST['lng']);
        locupdate($db, $_SESSION['usr']->id, $lat, $lng);
        getloc($db, $_SESSION['usr']->id);
    }