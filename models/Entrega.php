<?php
class Entrega {
    private $conn;
    private $table_name = "entregas_produccion";

    public $id_entrega;
    public $id_costurera;
    public $id_producto;
    public $fecha_entrega;
    public $cantidad_buenas;
    public $es_arreglo;

    // Extra fields for views
    public $nombre_costurera;
    public $nombre_producto;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leerTodas() {
        // Usamos LEFT JOIN para costureras porque puede ser NULL si es arreglo
        $query = "SELECT e.id_entrega, e.id_costurera, e.id_producto, e.fecha_entrega, e.cantidad_buenas as piezas_buenas, e.es_arreglo,
                         IFNULL(c.nombre_completo, 'Taller (Arreglo)') as nombre_costurera, p.nombre_producto 
                  FROM " . $this->table_name . " e
                  LEFT JOIN costureras c ON e.id_costurera = c.id_costurera
                  JOIN productos p ON e.id_producto = p.id_producto
                  ORDER BY e.fecha_entrega DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_costurera, id_producto, fecha_entrega, cantidad_buenas, es_arreglo) 
                  VALUES (:id_costurera, :id_producto, :fecha, :buenas, :es_arreglo)";
        $stmt = $this->conn->prepare($query);

        // id_costurera can be NULL, so we handle it specially
        if (empty($this->id_costurera)) {
            $this->id_costurera = null;
        } else {
            $this->id_costurera = htmlspecialchars(strip_tags($this->id_costurera));
        }

        $this->id_producto = htmlspecialchars(strip_tags($this->id_producto));
        $this->fecha_entrega = htmlspecialchars(strip_tags($this->fecha_entrega));
        $this->cantidad_buenas = htmlspecialchars(strip_tags($this->cantidad_buenas));
        $this->es_arreglo = htmlspecialchars(strip_tags($this->es_arreglo));

        // Use PDO::PARAM_NULL for null values
        if (is_null($this->id_costurera)) {
            $stmt->bindValue(":id_costurera", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(":id_costurera", $this->id_costurera);
        }

        $stmt->bindParam(":id_producto", $this->id_producto);
        $stmt->bindParam(":fecha", $this->fecha_entrega);
        $stmt->bindParam(":buenas", $this->cantidad_buenas);
        $stmt->bindParam(":es_arreglo", $this->es_arreglo);

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
            $this->id_costurera = $row['id_costurera'];
            $this->id_producto = $row['id_producto'];
            $this->fecha_entrega = $row['fecha_entrega'];
            $this->cantidad_buenas = $row['cantidad_buenas'];
            $this->es_arreglo = $row['es_arreglo'];
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET id_costurera = :id_costurera, id_producto = :id_producto, fecha_entrega = :fecha, 
                      cantidad_buenas = :buenas, es_arreglo = :es_arreglo 
                  WHERE id_entrega = :id";
        $stmt = $this->conn->prepare($query);

        if (empty($this->id_costurera)) {
            $this->id_costurera = null;
        } else {
            $this->id_costurera = htmlspecialchars(strip_tags($this->id_costurera));
        }

        $this->id_producto = htmlspecialchars(strip_tags($this->id_producto));
        $this->fecha_entrega = htmlspecialchars(strip_tags($this->fecha_entrega));
        $this->cantidad_buenas = htmlspecialchars(strip_tags($this->cantidad_buenas));
        $this->es_arreglo = htmlspecialchars(strip_tags($this->es_arreglo));
        $this->id_entrega = htmlspecialchars(strip_tags($this->id_entrega));

        if (is_null($this->id_costurera)) {
            $stmt->bindValue(":id_costurera", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(":id_costurera", $this->id_costurera);
        }
        
        $stmt->bindParam(":id_producto", $this->id_producto);
        $stmt->bindParam(":fecha", $this->fecha_entrega);
        $stmt->bindParam(":buenas", $this->cantidad_buenas);
        $stmt->bindParam(":es_arreglo", $this->es_arreglo);
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
