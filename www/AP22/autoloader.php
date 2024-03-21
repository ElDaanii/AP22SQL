<?php
function miAutoloadUno($claseDesconocida){
    $fichero = "class/$claseDesconocida.php";
    if(file_exists($fichero)){
        require_once $fichero;
    }
}

spl_autoload_register("miAutoloadUno");

?>