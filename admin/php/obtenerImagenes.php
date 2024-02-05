<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_POST['directorio']))
{
    $directorio = getcwd().'/'.$_POST['directorio'];
    $ficheros1  = scandir($directorio,1);
     
    echo json_encode($ficheros1);
}else
{
    echo json_encode(array());
}

?>