<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once('Db.php');

class Usuarios {

    private $db = null;
    private $pepper = "c1isvFdxMDdmjOlvxpecFw";
    function __construct() {
      $this->db =  new Db();
      $this->db->createUserIfNotExists("user", "em@proinseg.com", "admin123");
    } 

    public function login($request)
    {
        $query = 'SELECT clave, nombre FROM usuarios WHERE correo = "'. $request['correo'] .'";';
        $datosUsuario = JSON_DECODE($this->db->query($query));
        $response = '';
        if (count($datosUsuario) > 0) {
            $pwd = $request['clave'];
            $pwd_hashed = $datosUsuario[0]->clave;
            
            if (password_verify($pwd, $pwd_hashed)) {
                $response = array('error' => false, 'mensaje' => 'Datos correctos' , 'usuario' => $datosUsuario[0]->nombre);
            } else {
                $response = array('error' => true, 'mensaje' => 'Contraseña incorrecta.');
            }
        } else {
            $response = array('error' => true, 'mensaje' => 'No existe usuario con los datos ingresados.');
        }
    
        return json_encode($response);
    }



    
    public function registrar($request)
    {
        
        $pwd = $request['clave'];
        $pwd_peppered = hash_hmac("sha256", $pwd, $this->pepper);
        $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);
        $query = 'INSERT INTO usuarios (correo,clave,nombre) VALUES ("'. $request['correo'] .'","'.$pwd_hashed.'","'.$request['nombre'].'");';
        echo $query;
        $this->db->query($query);     
    }

 
}
