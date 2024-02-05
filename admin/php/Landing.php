<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once('Db.php');
    require_once('File.php');

class Landing {


    private $db = null;

    function __construct() {
      $this->db =  new Db();
    } 

    public function listar($request)
    {
        return $this->db->query('select * from landing_'.$request['tipo']);
    }



    public function registrarLinea($request)
    {


        $file = new File();
        $ruta_foto_1 = '';
        if($_FILES['foto1']['size'] != 0 && $_FILES['foto1']['error'] == 0)
        {
            $response = $file->upload('foto1');
            if($response->error)
            {
                die('ERROR AL SUBIR ARCHIVO');
            }else 
            { 
                $ruta_foto_1 = "./imagenes_cargadas/".$response->nombre_archivo;
            }
        }  


        $ruta_foto_2 = '';
        if($_FILES['foto2']['size'] != 0 && $_FILES['foto2']['error'] == 0)
        {
            $response = $file->upload('foto2');
            if($response->error)
            {
                die('ERROR AL SUBIR SEGUNDO ARCHIVO');
            }else 
            { 
                $ruta_foto_2 = "./imagenes_cargadas/".$response->nombre_archivo;
            }
        }          
        
        

    
        $titulo = $request['titulo'];
        $descripcion = $request['descripcion'];
        $precio = $request['precio'];
        $foto1 = $ruta_foto_1;
        $foto2 = $ruta_foto_2;
        
        $query = "INSERT INTO landing_lineas (titulo,precio,descripcion,foto1,foto2) VALUES (";
        $query .=  "'".$titulo . "','".$precio . "','". $descripcion . "','" . $foto1 . "','" . $foto2 . "'";
        $query .= ")";    
        $this->db->query($query);
        echo json_encode(array('error' => false));
        
    }


    public function registrarPresentacion($request)
    {


        $ruta_galeria = '';
        if($_FILES['archivo']['size'] != 0 && $_FILES['archivo']['error'] != 0)
        {

                $fecha = date_create();

              
                $nuevaCarpeta = '../imagenes_cargadas/'.date_timestamp_get($fecha);
                if(!mkdir($nuevaCarpeta, 0777, true)) {
                    die('Fallo al crear las carpetas...');
                }else 
                {
                    
                    // Count # of uploaded files in array
                    $total = count($_FILES['archivo']['name']);

                    // Loop through each file
                    for( $i=0 ; $i < $total ; $i++ ) {

                    //Get the temp file path
                    $tmpFilePath = $_FILES['archivo']['tmp_name'][$i];

                    //Make sure we have a file path
                    if ($tmpFilePath != ""){
                        //Setup our new file path
                        $newFilePath = $nuevaCarpeta . '/' . $_FILES['archivo']['name'][$i];

                        //Upload the file into the temp dir
                        if(move_uploaded_file($tmpFilePath, $newFilePath)) {

                            $ruta_galeria = $nuevaCarpeta . '/';

                        } 
                    }
                    }                    
                }


        }                 
        

    
        $titulo = $request['titulo'];
        $archivo = $ruta_galeria;
        
        $query = "INSERT INTO landing_presentacion(titulo,archivo) VALUES (";
        $query .=  "'".$titulo . "','" . $archivo . "'";
        $query .= ")";    
        $this->db->query($query);
        echo json_encode(array('error' => false));
        
    } 
    
    public function registrarProyectosRealizados($request)
    {


        $ruta_galeria = '';
        if($_FILES['imagenes_galeria']['size'] != 0 && $_FILES['imagenes_galeria']['error'] != 0)
        {

                $fecha = date_create();

              
                $nuevaCarpeta = '../imagenes_cargadas/'.date_timestamp_get($fecha);
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
        

    
        $galeria = $ruta_galeria;
        
        $query = "INSERT INTO landing_proyectos(archivo) VALUES (";
        $query .=  "'" . $galeria . "'";
        $query .= ")";     
        $this->db->query($query);
        echo json_encode(array('error' => false));
        
    }     


    public function registrarTaller($request)
    {


        $ruta_galeria = '';
        if($_FILES['imagenes_galeria']['size'] != 0 && $_FILES['imagenes_galeria']['error'] != 0)
        {

                $fecha = date_create();

              
                $nuevaCarpeta = '../imagenes_cargadas/'.date_timestamp_get($fecha);
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
        

    
        $galeria = $ruta_galeria;
        
        $query = "INSERT INTO landing_taller(archivo) VALUES (";
        $query .=  "'" . $galeria . "'";
        $query .= ")";    
        $this->db->query($query);
        echo json_encode(array('error' => false));
        
    }     

    public function modificarLinea($request)
    {
        $titulo = $request['titulo'];
        $descripcion = $request['descripcion'];
        $precio = $request['precio'];

        $query = "UPDATE landing_lineas SET ";
        $query .= " titulo = '" . $titulo."'";
        $query .= " ,precio = '" . $precio."'";
        $query .= " ,descripcion = '" . $descripcion  ."' ";

        $file = new File();
        $ruta_foto_1 = '';
        if($_FILES['foto1']['size'] != 0 && $_FILES['foto1']['error'] == 0)
        {
            $response = $file->upload('foto1');
            if($response->error)
            {
                die('ERROR AL SUBIR ARCHIVO');
            }else 
            { 
                $ruta_foto_1 = "./imagenes_cargadas/".$response->nombre_archivo;
                $query .= " ,foto1 = '" . $ruta_foto_1  ."'";

            }
        }  


        $ruta_foto_2 = '';
        if($_FILES['foto2']['size'] != 0 && $_FILES['foto2']['error'] == 0)
        {
            $response = $file->upload('foto2');
            if($response->error)
            {
                die('ERROR AL SUBIR SEGUNDO ARCHIVO');
            }else 
            { 
                $ruta_foto_2 = "./imagenes_cargadas/".$response->nombre_archivo;
                $query .= " ,foto2 = '" . $ruta_foto_2 . "'";

            }
        }          
        $query .= " WHERE id = " . $request['idLinea'];
        $this->db->query($query);
        echo json_encode(array('error' => false));
        
    }  
    

    public function modificarPresentacion($request)
    {
        $titulo = $request['titulo'];
        $query = "UPDATE landing_presentacion SET ";
        $query .= " titulo = '" . $titulo . "'";
        
        
        $ruta_galeria = '';
        if($_FILES['archivo']['size'] != 0 && $_FILES['archivo']['error'] != 0)
        {

                $fecha = date_create();

              
                $nuevaCarpeta = '../imagenes_cargadas/'.date_timestamp_get($fecha);
                if(!mkdir($nuevaCarpeta, 0777, true)) {
                    die('Fallo al crear las carpetas...');
                }else 
                {
                    $error = false;
                    // Count # of uploaded files in array
                    $total = count($_FILES['archivo']['name']);

                    // Loop through each file
                    for( $i=0 ; $i < $total ; $i++ ) {

                            //Get the temp file path
                            $tmpFilePath = $_FILES['archivo']['tmp_name'][$i];

                            //Make sure we have a file path
                            if ($tmpFilePath != ""){
                                //Setup our new file path
                                $newFilePath = $nuevaCarpeta . '/' . $_FILES['archivo']['name'][$i];

                                //Upload the file into the temp dir
                                if(move_uploaded_file($tmpFilePath, $newFilePath)) {                         
                                    $ruta_galeria = $nuevaCarpeta . '/';
                                }else 
                                {
                                    $error = true;
                                }
                            }
                            
                    }         
                    
                    if(!$error && $ruta_galeria != '')
                    {
                        $query .= ", archivo =  '". $ruta_galeria ."'";
                    }                    
                }


        }                 
                

        $query .= " WHERE id = " . $request['idPresentacion'];
        $this->db->query($query);
        echo json_encode(array('error' => false));
        
    } 
    
    

    public function modificarProyectos($request)
    {

        $ruta_galeria = '';
        if($_FILES['imagenes_galeria']['size'] != 0 && $_FILES['imagenes_galeria']['error'] != 0)
        {

                $fecha = date_create();

              
                $nuevaCarpeta = '../imagenes_cargadas/'.date_timestamp_get($fecha);
                if(!mkdir($nuevaCarpeta, 0777, true)) {
                    die('Fallo al crear las carpetas...');
                }else 
                {
                    
                    // Count # of uploaded files in array
                    $total = count($_FILES['imagenes_galeria']['name']);
                    $error = false;
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
                                }else 
                                {
                                    $error = true;
                                }
                            }
                    }
                    
                        if(!$error && $ruta_galeria != '')
                        {
                            $query = "UPDATE landing_proyectos SET ";
                            $query .= " archivo =  '". $ruta_galeria ."'";
                            $query .= " WHERE id = " . $request['idProyectos'];
                                
                            $this->db->query($query);
                                
                            echo json_encode(array('error' => false));
                        }
                
                }


        }  


    }  
    


    public function modificarTaller($request)
    {

        $ruta_galeria = '';
        if($_FILES['imagenes_galeria']['size'] != 0 && $_FILES['imagenes_galeria']['error'] != 0)
        {

                $fecha = date_create();

              
                $nuevaCarpeta = '../imagenes_cargadas/'.date_timestamp_get($fecha);
                if(!mkdir($nuevaCarpeta, 0777, true)) {
                    die('Fallo al crear las carpetas...');
                }else 
                {
                    
                    // Count # of uploaded files in array
                    $total = count($_FILES['imagenes_galeria']['name']);
                    $error = false;
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
                                }else 
                                {
                                    $error = true;
                                }
                            }
                    }
                    
                        if(!$error && $ruta_galeria != '')
                        {
                            $query = "UPDATE landing_taller SET ";
                            $query .= " archivo =  '". $ruta_galeria ."'";
                            $query .= " WHERE id = " . $request['idTaller'];
                                
                            $this->db->query($query);
                            echo json_encode(array('error' => false));
                                
                        }
                
                }


        }  


    }    
    
    public function obtenerPresentacion()
    {
        return $this->db->query('select * from landing_presentacion');
    }   
    
    public function obtenerLineas()
    {
        return $this->db->query('select * from landing_lineas');
    }

    public function obtenerLineasDatatable()
    {
        $response =  array('data' => JSON_DECODE($this->db->query('select * from landing_lineas')));
        return json_encode($response);        
    }    
    
    public function obtenerTaller()
    {
        return $this->db->query('select * from landing_taller');
    }

    public function obtenerProyectos()
    {
        return $this->db->query('select * from landing_proyectos');
    }   
    
    public function eliminarLinea($request)
    {
        return $this->db->query('DELETE FROM landing_lineas WHERE id = '.$request['idLinea']);
    }        
    
    
}
