<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class Db {

    private $dsn = 'mysql:dbname=proinseg;host=localhost;port=3306';
    private $usuario = 'root';
    private $contraseña = 'admin123';   
    private $dbConnect = null;
    private $stmt = null;

    function __construct() {
        $this->dbConnect = new PDO($this->dsn, $this->usuario, $this->contraseña);

    }   
     
    function query($query) {
        $this->stmt = $this->dbConnect->prepare($query);
        $this->stmt->execute();
        return json_encode($this->stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    function createUserIfNotExists($nombre, $correo, $clave) {
        try {
            $query = "SELECT COUNT(*) AS count FROM usuarios WHERE nombre = :nombre";
            $this->stmt = $this->dbConnect->prepare($query);
            $this->stmt->bindParam(':nombre', $nombre);
            $this->stmt->execute();
            $result = $this->stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] == 0) {
                $hashed_password = password_hash($clave, PASSWORD_DEFAULT);
                $query = "INSERT INTO usuarios (nombre, correo, clave) VALUES (:nombre, :correo, :clave)";
                $this->stmt = $this->dbConnect->prepare($query);
                $this->stmt->bindParam(':nombre', $nombre);
                $this->stmt->bindParam(':correo', $correo);
                $this->stmt->bindParam(':clave', $hashed_password);
                $this->stmt->execute();
                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>