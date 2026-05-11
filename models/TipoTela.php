<?php
class TipoTela {
    private $conn;
    private $table_name = "tipos_tela";

    public $id_tipo_tela;
    public $nombre_tela;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leerTodos() {
        $query = "SELECT id_tipo_tela, nombre_tela FROM " . $this->table_name . " ORDER BY nombre_tela ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (nombre_tela) VALUES (:nombre)";
        $stmt = $this->conn->prepare($query);

        $this->nombre_tela = htmlspecialchars(strip_tags($this->nombre_tela));
        $stmt->bindParam(":nombre", $this->nombre_tela);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    public function obtenerPorId($id) {
        $query = "SELECT id_tipo_tela, nombre_tela FROM " . $this->table_name . " WHERE id_tipo_tela = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_tipo_tela = $row['id_tipo_tela'];
            $this->nombre_tela = $row['nombre_tela'];
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET nombre_tela = :nombre WHERE id_tipo_tela = :id";
        $stmt = $this->conn->prepare($query);

        $this->nombre_tela = htmlspecialchars(strip_tags($this->nombre_tela));
        $this->id_tipo_tela = htmlspecialchars(strip_tags($this->id_tipo_tela));

        $stmt->bindParam(':nombre', $this->nombre_tela);
        $stmt->bindParam(':id', $this->id_tipo_tela);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    public function eliminar($id) {
        // Borrado físico. Si falla, es porque la llave foránea RESTRICT lo impide.
        $query = "DELETE FROM " . $this->table_name . " WHERE id_tipo_tela = ?";
        $stmt = $this->conn->prepare($query);
        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(1, $id);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            // El error 23000 indica violación de restricción de clave foránea
            if ($e->getCode() == 23000) {
                return 'en_uso';
            }
            return false;
        }
    }
}
?>
