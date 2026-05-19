<?php
require_once 'models/Entrega.php';
require_once 'models/Costurera.php';
require_once 'models/Producto.php';

class EntregasController {
    private $db;
    private $entrega;
    private $costurera;
    private $producto;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/login");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->entrega = new Entrega($this->db);
        $this->costurera = new Costurera($this->db);
        $this->producto = new Producto($this->db);
    }

    public function index() {
        $stmt = $this->entrega->leerTodas();
        $entregas = $stmt->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/entregas/index.php';
        require_once 'views/layouts/footer.php';
    }

    public function crear() {
        // Obtener costureras activas
        $stmtCos = $this->costurera->leerTodas();
        $costureras = $stmtCos->fetchAll();

        // Obtener productos activos
        $stmtProd = $this->producto->leerTodos();
        $productos = $stmtProd->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/entregas/crear.php';
        require_once 'views/layouts/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->entrega->es_arreglo = isset($_POST['es_arreglo']) ? 1 : 0;
            $this->entrega->id_costurera = ($this->entrega->es_arreglo == 1) ? null : $_POST['id_costurera'];
            $this->entrega->id_producto = $_POST['id_producto'];
            $this->entrega->fecha_entrega = $_POST['fecha_entrega'];
            $this->entrega->cantidad_buenas = $_POST['piezas_buenas'];

            if ($this->entrega->crear()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas?msg=creado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas?msg=error");
            }
        }
    }

}
?>
