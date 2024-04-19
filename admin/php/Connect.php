<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class Db {
    public $aMemberVar = 'aMemberVar Member Variable';
    public $aFuncName = 'aMemberFunc';
    private $dsn = 'mysql:dbname=proinseg;host=localhost;port=3306';
    private $usuario = 'proinseg';
    private $contraseña = 'Meza22760519';   
    private $dbConnect = null;
    private $stmt = null;

    function __construct() {
        $this->dbConnect = new PDO($this->dsn, $this->usuario, $this->contraseña);

    }    
    function query($query) {
        $this->stmt = $this->dbConnect->prepare($query);
        $this->stmt->execute();
        $this->stmt->bindColumn('pais', $pais);
        return json_encode($this->stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}

    $db = new Db();
    echo $db->query('select * from pais;');
    $db->createUserIfNotExists("user", "em@proinseg.com", "admin123");

?>