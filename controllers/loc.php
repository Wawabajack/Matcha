<?php
    if (isset($_POST['lat']))
    {
        fieldUpdate($db, $_POST['lat'],$_SESSION['usr']->id, 'lat', 'profiles');
        fieldUpdate($db, $_POST['lng'],$_SESSION['usr']->id, 'lng', 'profiles');
        mkdir('oui');
    }