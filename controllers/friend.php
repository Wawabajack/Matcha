<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/miscfuncs.php');

    if (isset($_SESSION['search']) && isset($_SESSION['usr']->id) && isset($_SESSION['profile']->id) && isset($_SESSION['prefs']->id)
        && (isset($_POST['friend']) && ($_POST['friend'] == "1" || $_POST['friend'] == "-1" || $_POST['friend'] == "0")) || (isset($_POST['block']) && $_POST['block'] == "1") || (isset($_POST['report']) && $_POST['report'] == "1"))
    {
        $block = isBlocked($db, $_SESSION['search']);
        if (isset($_POST['report']) && $_POST['report'] == "1" && !isset($block->value))
        {
            $user = getUserInfo($db, $_SESSION['search']);
            $warns = $user->warnings + 1;
            $sql = "UPDATE `users` SET `warnings` = :warnings WHERE `id` = :uid";
            $res = $db->prepare($sql);
            $res->bindParam(':uid', $_SESSION['search']);
            $res->bindParam(':warnings', $warns);
            $res->execute();
            $friend = isBlocked($db, $_SESSION['search']);
            if (isset($friend->value))
                updateFriend($db, $_SESSION['search'], -1);
            else
                insertFriend($db, $_SESSION['search'], -1);
            unset($_SESSION['search']);
            header('refresh:0;url=/index.php');
        }
        else {
            $val = 0;
            if (isset($_POST['block']))
                $post = -1;
            else
                $post = $_POST['friend'];
            $friend = isBlocked($db, $_SESSION['search']);
            if (isset($friend->value)){
                $val = 0;
                if ($friend->value == "0")
                    $val = 1;
                if (isset($_POST['block']))
                    $val = -1;
                updateFriend($db, $_SESSION['search'], $val);
            }
            else
                insertFriend($db, $_SESSION['search'], $post);
            if ($val == 1)
                addPop($db, $_SESSION['search'], 5);
            else
                subPop($db, $_SESSION['search'], 5);
            if (isset($_SESSION['search']) && $val != -1)
            {
                $username = getUserInfo($db, $_SESSION['search']);
                unset($_SESSION['search']);
                header('refresh:0;url=/pages/profile.php?user=' . strtolower($username->username));
            }
            else
            {
                unset($_SESSION['search']);
                header('refresh:0;url=/index.php');
            }
        }
    }
    else
    {
        unset($_SESSION['search']);
        header('refresh:0;url=/pages/error401.html');
    }