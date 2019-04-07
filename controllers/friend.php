<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/miscfuncs.php');

    if (isset($_POST['friend']))
        echo '<script>alert("OK");</script>';

    if (isset($_SESSION['usr']->id) && isset($_SESSION['profile']->id) && isset($_SESSION['prefs']->id)
        && isset($_POST['friend']) && ($_POST['friend'] == "1" || $_POST['friend'] == "-1"))
    {
        addFriend($db, $_POST['friend']);
        if (isset($_SESSION['search']->id))
        {
            $username = getUserInfo($db, $_SESSION['search']->id);
            header('refresh:0;url=/pages/profile.php?user=' . $username->username);
        }
        else
            header('refresh:0;url=/index.php');
    }
    else
        header('refresh:0;url=/pages/error401.html');