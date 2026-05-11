<?php
require_once 'models/Entrega.php';
require_once 'models/Asignacion.php';

class EntregasController {
    private $db;
    private $entrega;
    private $asignacion;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/login");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->entrega = new Entrega($this->db);
        $this->asignacion = new Asignacion($this->db);
    }

    public function index() {
        $stmt = $this->entrega->leerTodas();
        $entregas = $stmt->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/entregas/index.php';
        require_once 'views/layouts/footer.php';
    }

    public function crear() {
        // Solo obtener asignaciones que no estén entregadas para el selector
        // Usamos el leerTodas del modelo de asignación, pero lo filtraremos en la vista
        $stmtAsig = $this->asignacion->leerTodas();
        $asignaciones = $stmtAsig->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/entregas/crear.php';
        require_once 'views/layouts/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->entrega->id_asignacion = $_POST['id_asignacion'];
            $this->entrega->fecha_entrega = $_POST['fecha_entrega'];
            $this->entrega->cantidad_buenas = $_POST['piezas_buenas'];
            $this->entrega->cantidad_defectuosas = $_POST['piezas_malas'];

            if ($this->entrega->crear()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas?msg=creado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas?msg=error");
            }
        }
    }

    public function editar($id = null) {
        if ($id == null) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas");
            exit();
        }

        if ($this->entrega->obtenerPorId($id)) {
            $stmtAsig = $this->asignacion->leerTodas();
            $asignaciones = $stmtAsig->fetchAll();

            require_once 'views/layouts/header.php';
            require_once 'views/entregas/editar.php';
            require_once 'views/layouts/footer.php';
        } else {
            echo "Entrega no encontrada.";
        }
    }

    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->entrega->id_entrega = $id;
            $this->entrega->id_asignacion = $_POST['id_asignacion'];
            $this->entrega->fecha_entrega = $_POST['fecha_entrega'];
            $this->entrega->cantidad_buenas = $_POST['piezas_buenas'];
            $this->entrega->cantidad_defectuosas = $_POST['piezas_malas'];

            if ($this->entrega->actualizar()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas?msg=actualizado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas?msg=error");
            }
        }
    }

    public function eliminar($id) {
        if ($id != null) {
            if ($this->entrega->eliminar($id)) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas?msg=eliminado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas?msg=error");
            }
        }
    }
}
?>
