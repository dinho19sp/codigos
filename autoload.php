<?php

/**
 * Description of Autoloader
 *
 * @author Francisco Nascimento - d19sp.webdeveloper@outlook.com
 */

function autoLoad($className){
    
    #   Aicionar os diretarios que contem classes a ser instanciadas
    

    $directories = array(
        PATH_CORE,
        PATH_MODEL,
        PATH_CONTROLLER,
        PATH_HELPERS,
        PATH_APIS,
        PATH_APIS."Facebook/",
        PATH_APIS."MoIP/",
        PATH_DATABASE);
   
    #   Formatos de arquivos php
    
    $fileNameFormats = array(
      '%s.php',
      '%s.class.php',
      'class.%s.php',
      '%s.inc.php',
      '%s.barcode.php',
      '%s.helper.php'
    );

    #   this is to take care of the PEAR style of naming classes
   
    $path = str_ireplace('_', '/', $className);

    if(@include_once $path.'.php'){
        return;
    }
    
    foreach($directories as $directory){
        
        foreach($fileNameFormats as $fileNameFormat){
            
            $path = $directory.sprintf($fileNameFormat, $className);

            if(file_exists($path)){

                include_once $path;
                
                return;
            }
        }
    }
}

spl_autoload_register('autoLoad');
