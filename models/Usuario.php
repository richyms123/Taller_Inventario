<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios_admin";

    // Propiedades del objeto
    public $id_usuario;
    public $nombre_completo;
    public $usuario;
    public $password;
    public $activo;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para verificar login
    public function login($user, $pass) {
        $query = "SELECT id_usuario, nombre_completo, usuario, password, activo 
                  FROM " . $this->table_name . " 
                  WHERE usuario = :usuario AND activo = 1 LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        
        // Sanitizar
        $user = htmlspecialchars(strip_tags($user));
        
        // Vincular el valor
        $stmt->bindParam(':usuario', $user);
        
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar la contraseña encriptada con password_verify
            // En tu SQL la contraseña 'admin123' está hasheada
            if (password_verify($pass, $row['password'])) {
                $this->id_usuario = $row['id_usuario'];
                $this->nombre_completo = $row['nombre_completo'];
                $this->usuario = $row['usuario'];
                return true;
            }
        }
        return false;
    }
}
?>
