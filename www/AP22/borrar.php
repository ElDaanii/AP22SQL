<?php
require_once("autoloader.php");
function deleteTarea(){
    $conn = new Connection;
    $dataBase = $conn->getConn();

    $id = $_GET['id'];

    $datos = "DELETE  FROM tareas WHERE id = $id";

    $resultado = mysqli_query($dataBase, $datos);

    if ($resultado === true) {
        header("location: index.php");
    } else {
        echo "Error al subir los datos: " . mysqli_error($dataBase);
    }
}

deleteTarea();