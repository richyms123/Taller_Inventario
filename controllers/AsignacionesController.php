<?php
require_once 'models/Asignacion.php';
require_once 'models/Costurera.php';
require_once 'models/Producto.php';
require_once 'models/RolloTela.php';

class AsignacionesController {
    private $db;
    private $asignacion;
    private $costurera;
    private $producto;
    private $rolloTela;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/login");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->asignacion = new Asignacion($this->db);
        $this->costurera = new Costurera($this->db);
        $this->producto = new Producto($this->db);
        $this->rolloTela = new RolloTela($this->db);
    }

    public function index() {
        $stmt = $this->asignacion->leerTodas();
        $asignaciones = $stmt->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/asignaciones/index.php';
        require_once 'views/layouts/footer.php';
    }

    public function crear() {
        // Cargar listas para los selectores
        $costureras = $this->costurera->leerTodas()->fetchAll();
        $productos = $this->producto->leerTodos()->fetchAll();
        $rollos = $this->rolloTela->leerTodos()->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/asignaciones/crear.php';
        require_once 'views/layouts/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->asignacion->id_costurera = $_POST['id_costurera'];
            $this->asignacion->id_producto = $_POST['id_producto'];
            $this->asignacion->id_rollo = $_POST['id_rollo'];
            $this->asignacion->cantidad_asignada = $_POST['cantidad_asignada'];
            $this->asignacion->fecha_asignacion = $_POST['fecha_asignacion'];

            if ($this->asignacion->crear()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones?msg=creado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones?msg=error");
            }
        }
    }

    public function editar($id = null) {
        if ($id == null) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones");
            exit();
        }

        if ($this->asignacion->obtenerPorId($id)) {
            $costureras = $this->costurera->leerTodas()->fetchAll();
            $productos = $this->producto->leerTodos()->fetchAll();
            $rollos = $this->rolloTela->leerTodos()->fetchAll();

            require_once 'views/layouts/header.php';
            require_once 'views/asignaciones/editar.php';
            require_once 'views/layouts/footer.php';
        } else {
            echo "Asignación no encontrada.";
        }
    }

    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->asignacion->id_asignacion = $id;
            $this->asignacion->id_costurera = $_POST['id_costurera'];
            $this->asignacion->id_producto = $_POST['id_producto'];
            $this->asignacion->id_rollo = $_POST['id_rollo'];
            $this->asignacion->cantidad_asignada = $_POST['cantidad_asignada'];
            $this->asignacion->fecha_asignacion = $_POST['fecha_asignacion'];
            $this->asignacion->estado = $_POST['estado'];

            if ($this->asignacion->actualizar()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones?msg=actualizado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones?msg=error");
            }
        }
    }

    public function eliminar($id) {
        if ($id != null) {
            $resultado = $this->asignacion->eliminar($id);
            if ($resultado === true) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones?msg=eliminado");
            } elseif ($resultado === 'en_uso') {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones?msg=error_en_uso");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones?msg=error");
            }
        }
    }
}
?>
