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

        $registros = "SELECT * FROM tareas";
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
        $html .= '<tr><td colspan="6" align="center"><h1>REGISTROS</h1></td></tr>';
        $html .= '<tr>';
        $html .= '<tr><th>Id</th><th>Titulo</th><th>Descripcion</th><th>Fecha_creacion</th><th>Fecha_vencimiento</th><th>Modificar</th></tr>';

        foreach ($datos as $data) {
            $html .= '<tr>';
            $html .= '<td>' . $data['id'] . '</td>';
            $html .= '<td><a href="list.php?id=' . $data['id'] . '">' . $data['titulo'] . '</a></td>';
            $html .= '<td>' . $data['descripcion'] . '</td>';
            $html .= '<td>' . $data['fecha_creacion'] . '</td>';
            $html .= '<td>' . $data['fecha_vencimiento'] . '</td>';
            $html .= '<td style="text-align: center;">' . '<a href="modifica.php?id=' . $data['id'] . '"><img src="form/editar.png" style="width: 30px; height: 30px;"></a>' . '</td>';
            $html .= '</tr>';
        }
    
        $html .= '</table>';
        echo $html;
    }

}