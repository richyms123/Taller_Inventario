<?php
class Entrega {
    private $conn;
    private $table_name = "entregas_produccion";

    public $id_entrega;
    public $id_asignacion;
    public $fecha_entrega;
    public $cantidad_buenas;
    public $cantidad_defectuosas;

    // Extra fields
    public $nombre_costurera;
    public $nombre_producto;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leerTodas() {
        $query = "SELECT e.id_entrega, e.id_asignacion, e.fecha_entrega, e.cantidad_buenas as piezas_buenas, e.cantidad_defectuosas as piezas_malas, 
                         c.nombre_completo as nombre_costurera, p.nombre_producto 
                  FROM " . $this->table_name . " e
                  JOIN asignaciones_trabajo a ON e.id_asignacion = a.id_asignacion
                  JOIN costureras c ON a.id_costurera = c.id_costurera
                  JOIN productos p ON a.id_producto = p.id_producto
                  ORDER BY e.fecha_entrega DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_asignacion, fecha_entrega, cantidad_buenas, cantidad_defectuosas) 
                  VALUES (:id_asignacion, :fecha, :buenas, :malas)";
        $stmt = $this->conn->prepare($query);

        $this->id_asignacion = htmlspecialchars(strip_tags($this->id_asignacion));
        $this->fecha_entrega = htmlspecialchars(strip_tags($this->fecha_entrega));
        $this->cantidad_buenas = htmlspecialchars(strip_tags($this->cantidad_buenas));
        $this->cantidad_defectuosas = htmlspecialchars(strip_tags($this->cantidad_defectuosas));

        $stmt->bindParam(":id_asignacion", $this->id_asignacion);
        $stmt->bindParam(":fecha", $this->fecha_entrega);
        $stmt->bindParam(":buenas", $this->cantidad_buenas);
        $stmt->bindParam(":malas", $this->cantidad_defectuosas);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_entrega = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_entrega = $row['id_entrega'];
            $this->id_asignacion = $row['id_asignacion'];
            $this->fecha_entrega = $row['fecha_entrega'];
            $this->cantidad_buenas = $row['cantidad_buenas'];
            $this->cantidad_defectuosas = $row['cantidad_defectuosas'];
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET id_asignacion = :id_asignacion, fecha_entrega = :fecha, 
                      cantidad_buenas = :buenas, cantidad_defectuosas = :malas 
                  WHERE id_entrega = :id";
        $stmt = $this->conn->prepare($query);

        $this->id_asignacion = htmlspecialchars(strip_tags($this->id_asignacion));
        $this->fecha_entrega = htmlspecialchars(strip_tags($this->fecha_entrega));
        $this->cantidad_buenas = htmlspecialchars(strip_tags($this->cantidad_buenas));
        $this->cantidad_defectuosas = htmlspecialchars(strip_tags($this->cantidad_defectuosas));
        $this->id_entrega = htmlspecialchars(strip_tags($this->id_entrega));

        $stmt->bindParam(":id_asignacion", $this->id_asignacion);
        $stmt->bindParam(":fecha", $this->fecha_entrega);
        $stmt->bindParam(":buenas", $this->cantidad_buenas);
        $stmt->bindParam(":malas", $this->cantidad_defectuosas);
        $stmt->bindParam(":id", $this->id_entrega);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_entrega = ?";
        $stmt = $this->conn->prepare($query);
        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(1, $id);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }
}
?>
