<?php

    class Uploader
    {
        private $destinationPath;
        private $errorMessage;
        private $extensions;
        private $allowAll;
        private $maxSize;
        private $uploadName;
        private $seqnence;
        public $name='Uploader';
        public $useTable    =false;

        function setDir($path){
            $this->destinationPath  =   $path;
            $this->allowAll =   false;
        }

        function allowAllFormats(){
            $this->allowAll =   true;
        }

        function setMaxSize($sizeMB){
            $this->maxSize  =   $sizeMB * (3060*3060);
        }

        function setExtensions($options){
            $this->extensions   =   $options;
        }

        function setSameFileName(){
            $this->sameFileName =   true;
            $this->sameName =   true;
        }
        function getExtension($string){
            $ext    =   "";
            try{
                    $parts  =   explode(".",$string);
                    $ext        =   strtolower($parts[count($parts)-1]);
            }catch(Exception $c){
                    $ext    =   "";
            }
            return $ext;
    }

        function setMessage($message){
            $this->errorMessage =   $message;
        }

        function getMessage(){
            return $this->errorMessage;
        }

        function getUploadName(){
            return $this->uploadName;
        }
        function setSequence($seq){
            $seq;
    }

    function getRandom(){
        return strtotime(date('Y-m-d H:i:s')).rand(1111,9999).rand(11,99).rand(111,999);
    }
    function sameName($true){
        $this->sameName =   $true;
    }
    
    function uploadFile($fileBrowse){
            $result =   false;
            $size   =   $_FILES[$fileBrowse]["size"];
            $name   =   $_FILES[$fileBrowse]["name"];
            $ext    =   $this->getExtension($name);
            if(!is_dir($this->destinationPath)){
                $this->setMessage("No existe el directorio ".$this->destinationPath);
            }else if(!is_writable($this->destinationPath)){
                $this->setMessage("No se puede escribir sobre ".$this->destinationPath);
            }else if(empty($name)){
                $this->setMessage("No se seleccionó ningún archivo ");
            }else if($size>$this->maxSize){
                $this->setMessage("Archivo ".$name." demasiado largo ".$size);
            }else if($this->allowAll || (!$this->allowAll && in_array($ext,$this->extensions))){

            
                $this->uploadName   =  substr(md5(rand(1111,9999)),0,8).$this->getRandom().rand(1111,1000).rand(99,9999).".".$ext;
        

                if(move_uploaded_file($_FILES[$fileBrowse]["tmp_name"],$this->destinationPath.$this->uploadName)){
                    
                    $result =   true;
                }else{
                    $this->setMessage("Error al cargar archivo, intente nuevamente.");
                }
            }else{
                $this->setMessage("Formato de archivo inválido.");
            }
            return $result;
    }

    function deleteUploaded(){
        unlink($this->destinationPath.$this->uploadName);
    }

    }

?>