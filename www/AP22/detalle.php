<?php
require_once("autoloader.php");

$mod = new Modelo;

session_start();

function showData(){
    $conn = new Connection;
    $dataBase = $conn->getConn();

    $mod = new Modelo;

    $id = $_GET["id"];

    $data = "SELECT * FROM tareas WHERE id = $id";

    $sql = mysqli_query($dataBase, $data);

    $html = '<table border="1">';
        $html .= '<tr>';
        $html .= '<tr><td colspan="7" align="center"><h1>REGISTROS</h1></td></tr>';
        $html .= '<tr>';
        $html .= '<tr><th>Id</th><th>Titulo</th><th>Descripcion</th><th>Fecha_creacion</th><th>Fecha_vencimiento</th><th>Modificar</th><th>Eliminar</th></tr>';

        $cont=0;
        foreach ($sql as $datos) {
                $html .= '<tr>';
                $html .= '<td>' . $datos['id'] . '</td>';
                $html .= '<td><a href="detalle.php?id=' . $datos['id'] . '">' . $datos['titulo'] . '</a></td>';
                $html .= '<td>' . $datos['descripcion'] . '</td>';
                $html .= '<td>' . $datos['fecha_creacion'] . '</td>';
                $html .= '<td>' . $datos['fecha_vencimiento'] . '</td>';
                $html .= '<td style="text-align: center;">' . '<a href="modifica.php?id=' . $datos['id'] . '"><img src="form/editar.png" style="width: 30px; height: 30px;"></a>' . '</td>';
                $html .= '<td style="text-align: center;">' . '<a href="borrar.php?id=' . $datos['id'] . '"><img src="form/papelera.png" style="width: 30px; height: 30px;"></a>' . '</td>';
                $html .= '</tr>';
                $cont ++;   
            }

        $html .= '<footer>';
            $html .= '<tr><td colspan="7" align="center"><a href = "nueva.php">Añadir nuevo registro</td></tr>';
            $html .= '<tr><td colspan="7" align="center"><a href = "index.php?page=' . $pagina = $mod->getCurrentPage() . '">Volver</td></tr>';
            $html .= '</footer>';

        $html .= '</table>';
    echo $html;
}

showData();
