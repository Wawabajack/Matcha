<?php
    require_once('../config/db_connect.php');
    require_once('../scripts/queryfuncs.php');
    require_once('../scripts/checkfuncs.php');
    require_once('../scripts/miscfuncs.php');

    if (isset($_POST['register'])) {
        if (!postRegCheck($_POST))
            error(3);
    }
    ?>

<form action="" method="post">
    Username: <input type="text" name="username" required><br/>
    Name: <input type="text" name="name" required><br/>
    Surname: <input type="text" name="surname" required><br/>
    Mail: <input type="email" autocomplete="mail" name="mail" required><br/>
    Pass: <input type="password" name="pwd" autocomplete="current-password" required><br/>
    <input type="submit" value="Go" name="register">
</form>

