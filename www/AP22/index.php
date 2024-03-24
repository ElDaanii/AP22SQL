<?php
require_once("class/modelo.php");
?>

<html>
    </body>
        <div>
            <?php
                $mod = new Modelo;
                $dataBase = $mod->showAllTasks();
                $dataBase = $mod->showNavigation();
            ?>
        </div>
    </body>
</html>