<?php 
header('Access-Control-Allow-Origin: *');

function conectarDB() : mysqli{
    $host = 'localhost';
    $username = 'root';
    $passwd = 'root';   
    $dbname = 'bienes_raices';
    $port = 3310;
    $db =  new mysqli($host, $username, $passwd, $dbname, $port);
    $db -> set_charset('utf8'); 

    if ( !$db ) {
        echo "Error en la conexión";
        exit;
    }

    return $db;
}