<?php
class Producto {
    private $conn;
    private $table_name = "productos";

    public $id_producto;
    public $nombre_producto;
    public $descripcion;
    public $precio_maquila;
    public $tipo_maquina;
    public $activo;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Leer todos los productos activos
    public function leerTodos() {
        $query = "SELECT id_producto, nombre_producto, descripcion, precio_maquila, tipo_maquina, activo 
                  FROM " . $this->table_name . " 
                  WHERE activo = 1 ORDER BY nombre_producto ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Crear un nuevo producto o reactivar uno eliminado
    public function crear() {
        $this->nombre_producto = htmlspecialchars(strip_tags($this->nombre_producto));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio_maquila = htmlspecialchars(strip_tags($this->precio_maquila));
        $this->tipo_maquina = htmlspecialchars(strip_tags($this->tipo_maquina));

        // 1. Verificar si ya existe un producto con ese nombre
        $check_query = "SELECT id_producto, activo FROM " . $this->table_name . " WHERE nombre_producto = :nombre";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(':nombre', $this->nombre_producto);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            $row = $check_stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['activo'] == 1) {
                // Existe y está activo, no se puede duplicar
                return false;
            } else {
                // Existe pero fue "eliminado" (activo = 0). Lo reactivamos y actualizamos.
                $update_query = "UPDATE " . $this->table_name . " 
                                 SET descripcion = :descripcion, precio_maquila = :precio, tipo_maquina = :tipo_maquina, activo = 1 
                                 WHERE id_producto = :id";
                $update_stmt = $this->conn->prepare($update_query);
                
                $update_stmt->bindParam(':descripcion', $this->descripcion);
                $update_stmt->bindParam(':precio', $this->precio_maquila);
                $update_stmt->bindParam(':tipo_maquina', $this->tipo_maquina);
                $update_stmt->bindParam(':id', $row['id_producto']);
                
                try {
                    return $update_stmt->execute();
                } catch(PDOException $e) {
                    return false;
                }
            }
        }

        // 2. Si no existe, crearlo normalmente
        $query = "INSERT INTO " . $this->table_name . " 
                  (nombre_producto, descripcion, precio_maquila, tipo_maquina, activo) 
                  VALUES (:nombre, :descripcion, :precio, :tipo_maquina, 1)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre_producto);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precio", $this->precio_maquila);
        $stmt->bindParam(":tipo_maquina", $this->tipo_maquina);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    // Obtener un solo producto por ID
    public function obtenerPorId($id) {
        $query = "SELECT id_producto, nombre_producto, descripcion, precio_maquila, tipo_maquina, activo 
                  FROM " . $this->table_name . " 
                  WHERE id_producto = ? AND activo = 1 LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_producto = $row['id_producto'];
            $this->nombre_producto = $row['nombre_producto'];
            $this->descripcion = $row['descripcion'];
            $this->precio_maquila = $row['precio_maquila'];
            $this->tipo_maquina = $row['tipo_maquina'];
            $this->activo = $row['activo'];
            return true;
        }
        return false;
    }

    // Actualizar producto
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre_producto = :nombre, descripcion = :descripcion, precio_maquila = :precio, tipo_maquina = :tipo_maquina 
                  WHERE id_producto = :id";
        $stmt = $this->conn->prepare($query);

        $this->nombre_producto = htmlspecialchars(strip_tags($this->nombre_producto));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio_maquila = htmlspecialchars(strip_tags($this->precio_maquila));
        $this->tipo_maquina = htmlspecialchars(strip_tags($this->tipo_maquina));
        $this->id_producto = htmlspecialchars(strip_tags($this->id_producto));

        $stmt->bindParam(':nombre', $this->nombre_producto);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':precio', $this->precio_maquila);
        $stmt->bindParam(':tipo_maquina', $this->tipo_maquina);
        $stmt->bindParam(':id', $this->id_producto);

        try {
            if($stmt->execute()) {
                return true;
            }
        } catch(PDOException $e) {
            return false;
        }
        return false;
    }

    // Eliminar producto (Borrado lógico)
    public function eliminar($id) {
        $query = "UPDATE " . $this->table_name . " SET activo = 0 WHERE id_producto = ?";
        $stmt = $this->conn->prepare($query);
        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(1, $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
