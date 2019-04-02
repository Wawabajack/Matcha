<?php
$ip = $_SERVER['REMOTE_ADDR']; // Recuperation de l'IP du visiteur
$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip)); //connection au serveur de ip-api.com et recuperation des données
if($query && $query['status'] == 'success') 
{
    //code avec les variables
    echo "Bonjour visiteur de " . $query['country'] . "," . $query['city'];
}
else
{
    echo $ip;
    var_dump($query);
}

?>