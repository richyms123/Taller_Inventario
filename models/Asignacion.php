<?php
class Asignacion {
    private $conn;
    private $table_name = "asignaciones_trabajo";

    public $id_asignacion;
    public $id_costurera;
    public $id_rollo;
    public $rollos_utilizados;
    public $cantidad_asignada;
    public $fecha_asignacion;

    // Campos extra para vistas
    public $nombre_costurera;
    public $nombre_tela;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leerTodas() {
        $query = "SELECT a.id_asignacion, a.rollos_utilizados, a.cantidad_asignada, a.fecha_asignacion, 
                         c.nombre_completo as nombre_costurera, 
                         r.id_rollo, t.nombre_tela 
                  FROM " . $this->table_name . " a
                  JOIN costureras c ON a.id_costurera = c.id_costurera
                  JOIN rollos_tela r ON a.id_rollo = r.id_rollo
                  JOIN tipos_tela t ON r.id_tipo_tela = t.id_tipo_tela
                  ORDER BY a.fecha_asignacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_costurera, id_rollo, rollos_utilizados, cantidad_asignada, fecha_asignacion) 
                  VALUES (:id_costurera, :id_rollo, :rollos, :cantidad, :fecha)";
        $stmt = $this->conn->prepare($query);

        $this->id_costurera = htmlspecialchars(strip_tags($this->id_costurera));
        $this->id_rollo = htmlspecialchars(strip_tags($this->id_rollo));
        $this->rollos_utilizados = htmlspecialchars(strip_tags($this->rollos_utilizados));
        $this->cantidad_asignada = htmlspecialchars(strip_tags($this->cantidad_asignada));
        $this->fecha_asignacion = htmlspecialchars(strip_tags($this->fecha_asignacion));

        $stmt->bindParam(":id_costurera", $this->id_costurera);
        $stmt->bindParam(":id_rollo", $this->id_rollo);
        $stmt->bindParam(":rollos", $this->rollos_utilizados);
        $stmt->bindParam(":cantidad", $this->cantidad_asignada);
        $stmt->bindParam(":fecha", $this->fecha_asignacion);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_asignacion = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_asignacion = $row['id_asignacion'];
            $this->id_costurera = $row['id_costurera'];
            $this->id_rollo = $row['id_rollo'];
            $this->rollos_utilizados = $row['rollos_utilizados'];
            $this->cantidad_asignada = $row['cantidad_asignada'];
            $this->fecha_asignacion = $row['fecha_asignacion'];
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET id_costurera = :id_costurera,  
                      id_rollo = :id_rollo, rollos_utilizados = :rollos, cantidad_asignada = :cantidad, 
                      fecha_asignacion = :fecha 
                  WHERE id_asignacion = :id";
        $stmt = $this->conn->prepare($query);

        $this->id_costurera = htmlspecialchars(strip_tags($this->id_costurera));
        $this->id_rollo = htmlspecialchars(strip_tags($this->id_rollo));
        $this->rollos_utilizados = htmlspecialchars(strip_tags($this->rollos_utilizados));
        $this->cantidad_asignada = htmlspecialchars(strip_tags($this->cantidad_asignada));
        $this->fecha_asignacion = htmlspecialchars(strip_tags($this->fecha_asignacion));
        $this->id_asignacion = htmlspecialchars(strip_tags($this->id_asignacion));

        $stmt->bindParam(':id_costurera', $this->id_costurera);
        $stmt->bindParam(':id_rollo', $this->id_rollo);
        $stmt->bindParam(':rollos', $this->rollos_utilizados);
        $stmt->bindParam(':cantidad', $this->cantidad_asignada);
        $stmt->bindParam(':fecha', $this->fecha_asignacion);
        $stmt->bindParam(':id', $this->id_asignacion);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_asignacion = ?";
        $stmt = $this->conn->prepare($query);
        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(1, $id);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            if ($e->getCode() == 23000) {
                return 'en_uso'; 
            }
            return false;
        }
    }
}
?>
