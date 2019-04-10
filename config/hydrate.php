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
        if (isset($fake['gender'][0]))
            $gender = ucfirst($fake['gender'])[0];
        else
            $gender = "N";
        $username = ucfirst(strtolower($fake['login']['username']));
        $name = strtoupper($fake['name']['last']);
        $surname = ucfirst(strtolower($fake['name']['first']));
        $mail = $fake['email'];
        $pwd = password_hash('user', 1);
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
        $rand = rand(1, 30);
        if ($rand < 10)
            $genderpref = "N";
        else if ($rand < 61)
            $genderpref = "M";
        else
            $genderpref = "F";
        addRdomUser($db, $username, $name, $surname, $mail, $pwd, '0');
        $id = isThere($db, 'username', 'users', $username, 'id')->id;
        addRdomProfile($db, $id, $img, $gender, $birthdate, $popularity, $city,$lat, $lng);
        addRdomPrefs($db, $id, $genderpref);
        addRdomTags($db, $id, $str);
    }

    function ft_hydrate($db)
    {
        $i = 0;
        while ($i < 500)
        {
            addRandomUser($db);
            $i++;
        }
}

ft_hydrate($db);