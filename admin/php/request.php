<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $array = array( "color" => "red");
    $entidad = array_keys($_GET)[0];

    require_once($entidad . '.php');

    $clase = $entidad;
    $metodo = $_GET[$entidad];

    $object = new $entidad;
    echo $object->$metodo($_REQUEST);

?>
