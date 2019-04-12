<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');

    function addRandomUser($db)
    {
        $url = 'https://randomuser.me/api';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = json_decode(curl_exec($ch), true);
        $fake = $res['results'][0];
        $rand = rand(1, 100);
        if ($rand < 10)
            $gender = "N";
        else if ($rand < 61)
            $gender = "H";
        else
            $gender = "F";
        $username = ucfirst(strtolower($fake['login']['username'])) . rand(0, 99999);
        $name = strtoupper($fake['name']['last']);
        $surname = ucfirst(strtolower($fake['name']['first']));
        $mail = $name . $username . rand(0, 99999) . '@matcha-mailserver' . rand(0, 1000) . '.com';
        $pwd = '$2y$10$Hr/XpGPTP4PgKpBOeD30i..VGBVDtlUHjyQcHL2pbwhs6QxCYaJPm';
        $tags = array("#Natation", "#Cyclisme", "#Montagne", "#Cinema", "#Animes", "#Mangas", "#Gastronomie", "#Informatique", "#JeuxDeSociete", "#Condiments", "#Peche", "#Histoire", "#Ecologie", "#Musique", "#Parapente", "#Mode");
        $tag = array();
        $rand = rand(0, 20);
        $i = 0;
        while ($i <= $rand)
        {
            $tmp = rand(0, 15);
            $tag[$i] = $tags[$tmp];
            $i++;
        }

        $i = 0;
        $str = "";
        $tag = array_unique($tag);
        sort($tag);
        while ($i < count($tag))
        {
            $str = $str . $tag[$i] . ' ';
            $i++;
        }
        $str = substr($str, '0', '-1');
        $img = $fake['picture']['large'];
        $birthdate = substr($fake['dob']['date'], 0, 10);
        $popularity = rand(0, 2000);
        $city = ucfirst($fake['location']['city']);
        $lat = $fake['location']['coordinates']['latitude'] . '00';
        $lng = $fake['location']['coordinates']['longitude'] . '00';
        $rand = rand(1, 100);
        if ($rand < 10)
            $genderpref = "N";
        else if ($rand < 61)
            $genderpref = "H";
        else
            $genderpref = "F";
        addRdomUser($db, $username, $name, $surname, $mail, $pwd, '0');
        $id = isThere($db, 'username', 'users', $username, 'id')->id;
        addRdomProfile($db, $id, $img, $gender, $birthdate, $popularity, $city,$lat, $lng);
        addRdomPrefs($db, $id, $genderpref);
        addRdomTags($db, $id, $str);
    }

    function ft_hydrate($db, $usernb)
    {
        $i = 0;
        while ($i < $usernb)
        {
            addRandomUser($db);
            $i++;
        }
}

ft_hydrate($db, 20);
//ft_hydrate($db, 200);
//ft_hydrate($db, 200);