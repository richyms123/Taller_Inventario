<?php
class Defecto {
    private $conn;
    private $table_name = "defectos_produccion";

    public $id_defecto;
    public $id_producto;
    public $cantidad;
    public $fecha_registro;

    // Campos extra para vistas
    public $nombre_producto;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leerTodos() {
        $query = "SELECT d.id_defecto, d.cantidad, d.fecha_registro, p.nombre_producto 
                  FROM " . $this->table_name . " d
                  JOIN productos p ON d.id_producto = p.id_producto
                  ORDER BY d.fecha_registro DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_producto, cantidad, fecha_registro) 
                  VALUES (:id_producto, :cantidad, :fecha_registro)";
        $stmt = $this->conn->prepare($query);

        $this->id_producto = htmlspecialchars(strip_tags($this->id_producto));
        $this->cantidad = htmlspecialchars(strip_tags($this->cantidad));
        $this->fecha_registro = htmlspecialchars(strip_tags($this->fecha_registro));

        $stmt->bindParam(":id_producto", $this->id_producto);
        $stmt->bindParam(":cantidad", $this->cantidad);
        $stmt->bindParam(":fecha_registro", $this->fecha_registro);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }
}
?>
