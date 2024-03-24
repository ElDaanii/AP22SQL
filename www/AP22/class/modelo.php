<?php
require_once 'Connection.php';
class Modelo extends Connection {

    public function importar() {
        $dataBase = $this->getConn(); 
        
        $sql = "INSERT INTO tareas (titulo, descripcion, fecha_creacion, fecha_vencimiento) VALUES (?, ?, ?, ?)";
        $stmt = $dataBase->prepare($sql);
        
        $file = fopen("tareas.csv", "r");
        if ($file !== FALSE) {
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $fecha_creacion = date("Y-m-d", strtotime($data[2]));
                $fecha_vencimiento = date("Y-m-d", strtotime($data[3]));
                $stmt->bind_param("ssss", $data[0], $data[1], $fecha_vencimiento, $fecha_creacion);
                $stmt->execute();
            }
            fclose($file);
        } else {
            echo "Error: No se pudo abrir el archivo CSV.";
        }
        $stmt->close();
    }

    
  public function deleteList() {
    $conn = new Connection;
    $dataBase = $conn->getConn();
    $sql = "DELETE FROM tareas";
    $result = $dataBase->query($sql);
    return $result;
}

    public function init() {
        $this->deleteList();
        $this->importar();
    }

    public function getAllTasks() {
        $conn = new Connection;
        $dataBase = $conn->getConn();

        $resultados_por_pagina = 10;

        $pagina_actual = (isset($_GET['page']) && ($_GET['page'])) ? $_GET['page'] : 1;
        $inicio = ($pagina_actual - 1) * $resultados_por_pagina;

        $registros = "SELECT * FROM tareas LIMIT $inicio, $resultados_por_pagina";
        $resultado = mysqli_query($dataBase, $registros); 


        if (mysqli_num_rows($resultado) > 0){
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $datos[] = $fila;
            }
        }else {
            echo "Error: " . mysqli_error($dataBase);
        }
        return $datos;
    }

    public function showAllTasks(){
        $datos = $this->getAllTasks();
        $html = '<table border="1">';
        $html .= '<tr>';
        $html .= '<tr><td colspan="7" align="center"><h1>REGISTROS</h1></td></tr>';
        $html .= '<tr>';
        $html .= '<tr><th>Id</th><th>Titulo</th><th>Descripcion</th><th>Fecha_creacion</th><th>Fecha_vencimiento</th><th>Modificar</th><th>Eliminar</th></tr>';

        $cont=0;
        foreach ($datos as $datos) {
                $html .= '<tr>';
                $html .= '<td>' . $datos['id'] . '</td>';
                $html .= '<td><a href="list.php?id=' . $datos['id'] . '">' . $datos['titulo'] . '</a></td>';
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
        $html .= '</footer>';

    
        $html .= '</table>';
        echo $html;
    }

    public function showNavigation(){
        $conn = new Connection;
        $dataBase = $conn->getConn();

        $pagina_actual = (isset($_GET['page']) && ($_GET['page'])) ? $_GET['page'] : 1;

        $resultados_por_pagina = 10;

        $total_registros_query = "SELECT COUNT(*) AS total FROM tareas";
        $total_registros_resultado = mysqli_query($dataBase, $total_registros_query);
        $total_registros_fila = mysqli_fetch_assoc($total_registros_resultado);
        $total_registros = $total_registros_fila['total'];
        $total_paginas = ceil($total_registros / $resultados_por_pagina);

        echo '<div class="pagination">';

        $pagina_anterior = $pagina_actual - 1;
        $pagina_siguiente = $pagina_actual + 1;

        if ($pagina_actual == 0) {
            echo '<-'; 
        } else {
            echo '<a href="?page=' . $pagina_anterior . '"> <- </a> '; 
        }

        if ($pagina_actual == 1) {
            echo '<strong> Inicio </strong> '; 
        } else {
            echo '<a href="?page=1"> Inicio </a> ';
        }
        
        for ($pagina = 2; $pagina <= $total_paginas; $pagina++) {
            if ($pagina == $pagina_actual) { // Si la página actual coincide con la página actual del bucle
                echo '<strong><a href="?page=' . $pagina . '">' . $pagina . '</a></strong> '; // Resaltar en negrita
            } else {
                echo '<a href="?page=' . $pagina . '">' . $pagina . '</a> '; // Dejar como está
            }
        }  

        if ($pagina_actual == $total_paginas) {
            echo '<strong> Fin </strong> '; 
        } else {
            echo '<a href="?page=' . $total_paginas . '"> Fin </a> ';
        }
        
        if ($pagina_actual == 0) {
            echo '->'; 
        } else {
            echo '<a href="?page=' . $pagina_siguiente . '"> -> </a> '; 
        }
        
        
        echo '</div>';
    }

    public function showOrderAction(){
        
    }

}