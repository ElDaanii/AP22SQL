<?php
require_once("class/modelo.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<table class="greenTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>título</th>
            <th>Vencimiento</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="5">
                &nbsp;
            </td>
        </tr>
    </tfoot>
    <tbody>
        <tr> <?php $mod = new Modelo; ?>
            <td><?php $dataBase = $mod->showAllTasks(); ?></td>
            <td><?php $dataBase = $mod->showNavigation(); ?></td>
            <td>cell3_1</td>
        </tr>
    </tbody>
</table>

</body>
</html>
