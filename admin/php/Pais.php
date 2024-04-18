<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once('Db.php');

class Pais {

    private $id = null;
    private $pais = null;
    private $db = null;

    function __construct() {
        $this->db =  new Db();
        $this->db->createUserIfNotExists("user", "user@example.com", "123");
    } 

    public function obtenerPaises()
    {
        return  $this->db->query('select * from pais;');
    }
}
