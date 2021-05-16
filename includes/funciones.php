<?php 

function incluirTemplate(string $nombre, bool $inicio = false ){
    include TEMPLATES_URL."/${nombre}.php";
}

function estaAutenticado() : bool{
    session_start();
    $auth = $_SESSION['login'];

    return $auth ? true : false;
}