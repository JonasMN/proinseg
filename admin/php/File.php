<?php

require_once("Uploader.php");

class File extends Uploader
{

    public function __construct(){        
    }

    function upload($nameInput)
    {
        $dir = '../imagenes_cargadas/';
        $uploader   =   new Uploader();
        $uploader->setDir($dir);
        $uploader->setExtensions(array('jpg','jpeg','png','gif'));
        $uploader->setMaxSize(189329);                        

        if($uploader->uploadFile($nameInput)){ 
            $fileName  =   $uploader->getUploadName(); 
            $response = array('error' => false, 'nombre_archivo' => $fileName);
        }else{
            $error  = $uploader->getMessage();
            $response = array('error' => true, 'message' => $error);
            echo json_encode($response);
            die();
        }

        return (object) $response;
    }
}
    
 ?>