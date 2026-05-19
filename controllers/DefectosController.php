<?php
require_once 'models/Defecto.php';
require_once 'models/Producto.php';

class DefectosController {
    private $db;
    private $defecto;
    private $producto;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/login");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->defecto = new Defecto($this->db);
        $this->producto = new Producto($this->db);
    }

    public function crear() {
        // Obtener productos activos
        $stmtProd = $this->producto->leerTodos();
        $productos = $stmtProd->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/defectos/crear.php';
        require_once 'views/layouts/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->defecto->id_producto = $_POST['id_producto'];
            $this->defecto->cantidad = $_POST['cantidad'];
            $this->defecto->fecha_registro = $_POST['fecha_registro'];

            if ($this->defecto->crear()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas?msg=defecto_creado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas?msg=error");
            }
        }
    }
}
?>
