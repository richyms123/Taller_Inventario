<?php
require_once 'models/Costurera.php';

class CosturerasController {
    private $db;
    private $costurera;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/login");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->costurera = new Costurera($this->db);
    }

    public function index() {
        $stmt = $this->costurera->leerTodas();
        $costureras = $stmt->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/costureras/index.php';
        require_once 'views/layouts/footer.php';
    }

    public function crear() {
        require_once 'views/layouts/header.php';
        require_once 'views/costureras/crear.php';
        require_once 'views/layouts/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->costurera->nombre_completo = $_POST['nombre_completo'];
            $this->costurera->telefono = $_POST['telefono'];
            $this->costurera->fecha_ingreso = $_POST['fecha_ingreso'];
            $this->costurera->tipo_maquina = isset($_POST['tipo_maquina']) ? $_POST['tipo_maquina'] : 'Overlock';

            if ($this->costurera->crear()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/costureras?msg=creado");
            } else {
                echo "Error al registrar la costurera.";
            }
        }
    }

    public function editar($id = null) {
        if ($id == null) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/costureras");
            exit();
        }

        if ($this->costurera->obtenerPorId($id)) {
            require_once 'views/layouts/header.php';
            require_once 'views/costureras/editar.php';
            require_once 'views/layouts/footer.php';
        } else {
            echo "Costurera no encontrada.";
        }
    }

    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->costurera->id_costurera = $id;
            $this->costurera->nombre_completo = $_POST['nombre_completo'];
            $this->costurera->telefono = $_POST['telefono'];
            $this->costurera->fecha_ingreso = $_POST['fecha_ingreso'];
            $this->costurera->tipo_maquina = isset($_POST['tipo_maquina']) ? $_POST['tipo_maquina'] : 'Overlock';

            if ($this->costurera->actualizar()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/costureras?msg=actualizado");
            } else {
                echo "Error al actualizar los datos.";
            }
        }
    }

    public function eliminar($id) {
        if ($id != null) {
            if ($this->costurera->eliminar($id)) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/costureras?msg=eliminado");
            } else {
                echo "Error al eliminar a la costurera.";
            }
        }
    }
}
?>
