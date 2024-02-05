<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once('Db.php');

class Localidades {

    private $id = null;
    private $localidad = null;
    private $idProvincia = null;
    private $db = null;

    function __construct() {
        $this->db =  new Db();
    } 

    public function obtenerLocalidades()
    {
        return  $this->db->query('select * from localidades;');
    }

    public function obtenerLocalidadesXProvincia($request)
    {
        $idProvincia = $request['idProvincia'];
        return  $this->db->query('select * from localidades where id_provincia = ' . $idProvincia);
    }
}
