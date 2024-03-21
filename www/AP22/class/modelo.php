<?php
require_once 'Connection.php';
class Modelo extends Connection{

    public function importar() {
        $conn = new Connection;
        $dataBase = $conn->getConn();
        
        $sql = "INSERT INTO tareas (titulo, descripcion, fecha_creacion, fecha_vencimiento) VALUES (?, ?, ?, ?)";
        $stmt = $dataBase->prepare($sql);
        
        $file = fopen("tareas.csv", "r");
        if ($file !== FALSE) {
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $fecha_creacion = date("Y-m-d", strtotime($data[2]));
                $fecha_vencimiento = date("Y-m-d", strtotime($data[3]));
                $stmt->bind_param("ssss", $data[0], $data[1], $fecha_creacion, $fecha_vencimiento);
                $stmt->execute();
            }
            fclose($file);
        } else {
            echo "Error: No se pudo abrir el archivo CSV.";
        }
        $stmt->close();
        $dataBase->close();
    }
    
    public function deleteList() {
        $conn = new Connection;
        $dataBase = $conn->getConn();
        $sql = "DELETE FROM tareas";
        $result = $this->conn->query($dataBase, $sql);
        return $result;
    }

    public function init() {
        $this->deleteList();
        $this->importar();
    }

    
}