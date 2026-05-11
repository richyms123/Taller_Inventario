<?php
class RolloTela {
    private $conn;
    private $table_name = "rollos_tela";

    public $id_rollo;
    public $id_tipo_tela;
    public $cantidad_inicial;
    public $rollos_disponibles;
    public $fecha_ingreso;

    // Campos extra para vistas (JOIN)
    public $nombre_tela;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leerTodos() {
        $query = "SELECT r.id_rollo, r.id_tipo_tela, r.cantidad_inicial, r.rollos_disponibles, r.fecha_ingreso, t.nombre_tela 
                  FROM " . $this->table_name . " r
                  JOIN tipos_tela t ON r.id_tipo_tela = t.id_tipo_tela
                  ORDER BY r.id_rollo DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (id_tipo_tela, cantidad_inicial, rollos_disponibles, fecha_ingreso) 
                  VALUES (:id_tipo_tela, :cantidad_inicial, :rollos_disponibles, :fecha_ingreso)";
        $stmt = $this->conn->prepare($query);

        $this->id_tipo_tela = htmlspecialchars(strip_tags($this->id_tipo_tela));
        $this->cantidad_inicial = htmlspecialchars(strip_tags($this->cantidad_inicial));
        // Al crear, los disponibles son iguales a los iniciales
        $this->rollos_disponibles = htmlspecialchars(strip_tags($this->cantidad_inicial));
        $this->fecha_ingreso = htmlspecialchars(strip_tags($this->fecha_ingreso));

        $stmt->bindParam(":id_tipo_tela", $this->id_tipo_tela);
        $stmt->bindParam(":cantidad_inicial", $this->cantidad_inicial);
        $stmt->bindParam(":rollos_disponibles", $this->rollos_disponibles);
        $stmt->bindParam(":fecha_ingreso", $this->fecha_ingreso);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    public function obtenerPorId($id) {
        $query = "SELECT id_rollo, id_tipo_tela, cantidad_inicial, rollos_disponibles, fecha_ingreso 
                  FROM " . $this->table_name . " WHERE id_rollo = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_rollo = $row['id_rollo'];
            $this->id_tipo_tela = $row['id_tipo_tela'];
            $this->cantidad_inicial = $row['cantidad_inicial'];
            $this->rollos_disponibles = $row['rollos_disponibles'];
            $this->fecha_ingreso = $row['fecha_ingreso'];
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET id_tipo_tela = :id_tipo_tela, cantidad_inicial = :cantidad_inicial, 
                      rollos_disponibles = :rollos_disponibles, fecha_ingreso = :fecha_ingreso 
                  WHERE id_rollo = :id";
        $stmt = $this->conn->prepare($query);

        $this->id_tipo_tela = htmlspecialchars(strip_tags($this->id_tipo_tela));
        $this->cantidad_inicial = htmlspecialchars(strip_tags($this->cantidad_inicial));
        $this->rollos_disponibles = htmlspecialchars(strip_tags($this->rollos_disponibles));
        $this->fecha_ingreso = htmlspecialchars(strip_tags($this->fecha_ingreso));
        $this->id_rollo = htmlspecialchars(strip_tags($this->id_rollo));

        $stmt->bindParam(':id_tipo_tela', $this->id_tipo_tela);
        $stmt->bindParam(':cantidad_inicial', $this->cantidad_inicial);
        $stmt->bindParam(':rollos_disponibles', $this->rollos_disponibles);
        $stmt->bindParam(':fecha_ingreso', $this->fecha_ingreso);
        $stmt->bindParam(':id', $this->id_rollo);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_rollo = ?";
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
