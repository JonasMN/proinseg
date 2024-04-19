<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once('Db.php');
    require_once('File.php');

class Productos {

    private $id = null;
    private $producto = null;
    private $db = null;

    function __construct() {
      $this->db =  new Db();
      $this->db->createUserIfNotExists("user", "em@proinseg.com", "admin123");
    }

    public function listarProductos()
    {
        $response =  array('data' => JSON_DECODE($this->db->query('select * from productos;')));
        return json_encode($response);
    }


    public function listarProductosIndex($request)
    {
        $query = 'select * from productos where categoria = "'.$request['categoria'].'" order by orden desc;'; 
        return $this->db->query($query);
    }

    public function obtenerProductosPorId($request)
    {
        $query = 'SELECT * FROM `productos` WHERE id = '.$request['id'].';'; 
        return $this->db->query($query);
    }


    public function eliminarProducto($request)
    {
        return $this->db->query('DELETE FROM productos WHERE id = '.$request['idProducto']);
    }    


     public function registrarProducto($request)
    {


        $file = new File();
        $ruta_imagen_index = '';
        if($_FILES['imagen_index']['size'] != 0 && $_FILES['imagen_index']['error'] == 0)
        {
            $response = $file->upload('imagen_index');
            if($response->error)
            {
                die('ERROR AL SUBIR ARCHIVO');
            }else 
            { 
                $ruta_imagen_index = "/imagenes_cargadas/".$response->nombre_archivo;
            }
        }  
        
        


        
        $ruta_galeria = '';
        if($_FILES['imagenes_galeria']['size'] != 0 && $_FILES['imagenes_galeria']['error'] != 0)
        {

                $fecha = date_create();

              
                $nuevaCarpeta = '/imagenes_cargadas/'.date_timestamp_get($fecha);
                if(!mkdir($nuevaCarpeta, 0777, true)) {
                    die('Fallo al crear las carpetas...');
                }else 
                {
                    
                    // Count # of uploaded files in array
                    $total = count($_FILES['imagenes_galeria']['name']);

                    // Loop through each file
                    for( $i=0 ; $i < $total ; $i++ ) {

                    //Get the temp file path
                    $tmpFilePath = $_FILES['imagenes_galeria']['tmp_name'][$i];

                    //Make sure we have a file path
                    if ($tmpFilePath != ""){
                        //Setup our new file path
                        $newFilePath = $nuevaCarpeta . '/' . $_FILES['imagenes_galeria']['name'][$i];

                        //Upload the file into the temp dir
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {

                            $ruta_galeria = $nuevaCarpeta . '/';

                        } 
                    }
                    }                    
                }


        }          
        
    
        $orden = $request['orden'];
        $nombre = $request['nombre'];
        $descripcion = $request['descripcion'];
        $foto_index = $ruta_imagen_index;
        $carpeta_fotos = $ruta_galeria;
        $precio = $request['precio'];
        $categoria = $request['categoria'];
        $caracteristicas = $request['caracteristicas'];
        
        $query = "INSERT INTO productos (orden,nombre,descripcion,foto_index,carpeta_fotos,precio,caracteristicas,categoria) VALUES (";
        $query .= $orden . " , '" . $nombre . "', '" . $descripcion . "', '" . $foto_index . "',";
        $query .= "'" . $carpeta_fotos . "'," . $precio . ",'" . $caracteristicas . "','" . $categoria . "'";
        $query .= ")";
        $this->db->query($query);
        echo json_encode(array('error' => false));
    }

    public function modificarProducto($request)
    {
     
        
    
        $orden = $request['orden'];
        $nombre = $request['nombre'];
        $descripcion = $request['descripcion'];
        $precio = $request['precio'];
        $categoria = $request['categoria'];
        $caracteristicas = $request['caracteristicas'];
        
        $query = "UPDATE productos SET ";
        $query .= " orden = " . $orden;
        $query .= " ,nombre = '" . $nombre  ."'";
        $query .= " ,descripcion = '" . $descripcion  ."'";
        $query .= " ,precio = " . $precio;
        $query .= " ,categoria = '" . $categoria . "'";
        $query .= " ,caracteristicas = '" . $caracteristicas ."'";

        $file = new File();
        $ruta_foto_1 = '';
        if($_FILES['imagen_index']['size'] != 0 && $_FILES['imagen_index']['error'] == 0)
        {
            $response = $file->upload('imagen_index');
            if($response->error)
            {
                die('ERROR AL SUBIR ARCHIVO');
            }else 
            { 
                $ruta_foto_1 = "/imagenes_cargadas/".$response->nombre_archivo;
                $query .= " ,foto_index = '" . $ruta_foto_1  ."'";

            }
        }

        $ruta_galeria = '';
        if($_FILES['imagenes_galeria']['size'] != 0 && $_FILES['imagenes_galeria']['error'] != 0)
        {

                $fecha = date_create();

                $error = false;
                $nuevaCarpeta = '/imagenes_cargadas/'.date_timestamp_get($fecha);
                if(!mkdir($nuevaCarpeta, 0777, true)) {
                    die('Fallo al crear las carpetas...');
                }else 
                {
                    
                    // Count # of uploaded files in array
                    $total = count($_FILES['imagenes_galeria']['name']);

                    // Loop through each file
                    for( $i=0 ; $i < $total ; $i++ ) {

                    //Get the temp file path
                    $tmpFilePath = $_FILES['imagenes_galeria']['tmp_name'][$i];

                    //Make sure we have a file path
                    if ($tmpFilePath != ""){
                        //Setup our new file path
                        $newFilePath = $nuevaCarpeta . '/' . $_FILES['imagenes_galeria']['name'][$i];

                        //Upload the file into the temp dir
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {

                            $ruta_galeria = $nuevaCarpeta . '/';

                        } else 
                        {
                            $error = true;
                        }
                    }
                    }     
                    
                    if(!$error && $ruta_galeria != '')
                    {
                        $query .= " ,carpeta_fotos = '" . $ruta_galeria  ."'";                            
                    }                    
                }


        }              

        $query .= " WHERE id = " . $request['idProducto'];
        
        $this->db->query($query);
        echo json_encode(array('error' => false));
    }    
}
