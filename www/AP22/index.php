<?php
require_once("class/modelo.php");
session_start(); 

$mod = new Modelo;

?>
<html>
    <body>
        <div>
            <?php
                $mod->showAllTasks();
                $mod->showNavigation();
                //$mod->showOrderAction('titulo');
                echo $mod->getCurrentPage(); 
            ?>
        </div>
    </body>
</html>
