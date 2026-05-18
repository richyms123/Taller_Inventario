<?php
class Costurera {
    private $conn;
    private $table_name = "costureras";

    public $id_costurera;
    public $nombre_completo;
    public $telefono;
    public $fecha_ingreso;
    public $tipo_maquina;
    public $activo;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leerTodas() {
        $query = "SELECT id_costurera, nombre_completo, telefono, fecha_ingreso, tipo_maquina, activo 
                  FROM " . $this->table_name . " 
                  WHERE activo = 1 ORDER BY nombre_completo ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nombre_completo, telefono, fecha_ingreso, tipo_maquina, activo) 
                  VALUES (:nombre, :telefono, :fecha, :tipo_maquina, 1)";
        $stmt = $this->conn->prepare($query);

        $this->nombre_completo = htmlspecialchars(strip_tags($this->nombre_completo));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->fecha_ingreso = htmlspecialchars(strip_tags($this->fecha_ingreso));
        $this->tipo_maquina = htmlspecialchars(strip_tags($this->tipo_maquina));

        $stmt->bindParam(":nombre", $this->nombre_completo);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":fecha", $this->fecha_ingreso);
        $stmt->bindParam(":tipo_maquina", $this->tipo_maquina);

        try {
            if($stmt->execute()) {
                return true;
            }
        } catch(PDOException $e) {
            return false;
        }
        return false;
    }

    public function obtenerPorId($id) {
        $query = "SELECT id_costurera, nombre_completo, telefono, fecha_ingreso, tipo_maquina, activo 
                  FROM " . $this->table_name . " 
                  WHERE id_costurera = ? AND activo = 1 LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_costurera = $row['id_costurera'];
            $this->nombre_completo = $row['nombre_completo'];
            $this->telefono = $row['telefono'];
            $this->fecha_ingreso = $row['fecha_ingreso'];
            $this->tipo_maquina = $row['tipo_maquina'];
            $this->activo = $row['activo'];
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre_completo = :nombre, telefono = :telefono, fecha_ingreso = :fecha, tipo_maquina = :tipo_maquina 
                  WHERE id_costurera = :id";
        $stmt = $this->conn->prepare($query);

        $this->nombre_completo = htmlspecialchars(strip_tags($this->nombre_completo));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->fecha_ingreso = htmlspecialchars(strip_tags($this->fecha_ingreso));
        $this->tipo_maquina = htmlspecialchars(strip_tags($this->tipo_maquina));
        $this->id_costurera = htmlspecialchars(strip_tags($this->id_costurera));

        $stmt->bindParam(':nombre', $this->nombre_completo);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':fecha', $this->fecha_ingreso);
        $stmt->bindParam(':tipo_maquina', $this->tipo_maquina);
        $stmt->bindParam(':id', $this->id_costurera);

        try {
            if($stmt->execute()) {
                return true;
            }
        } catch(PDOException $e) {
            return false;
        }
        return false;
    }

    public function eliminar($id) {
        $query = "UPDATE " . $this->table_name . " SET activo = 0 WHERE id_costurera = ?";
        $stmt = $this->conn->prepare($query);
        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(1, $id);

        try {
            if($stmt->execute()) {
                return true;
            }
        } catch(PDOException $e) {
            return false;
        }
        return false;
    }
}
?>
