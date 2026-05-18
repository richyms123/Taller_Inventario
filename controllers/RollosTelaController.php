<?php
require_once 'models/RolloTela.php';
require_once 'models/TipoTela.php';

class RollosTelaController {
    private $db;
    private $rolloTela;
    private $tipoTela;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/login");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->rolloTela = new RolloTela($this->db);
        $this->tipoTela = new TipoTela($this->db);
    }

    public function index() {
        $stmt = $this->rolloTela->leerTodos();
        $rollos = $stmt->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/rollos_tela/index.php';
        require_once 'views/layouts/footer.php';
    }

    public function crear() {
        // Obtener tipos de tela para el selector (dropdown)
        $stmtTelas = $this->tipoTela->leerTodos();
        $telas = $stmtTelas->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/rollos_tela/crear.php';
        require_once 'views/layouts/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->rolloTela->id_tipo_tela = $_POST['id_tipo_tela'];
            $this->rolloTela->cantidad_inicial = $_POST['cantidad_inicial'];
            $this->rolloTela->fecha_ingreso = $_POST['fecha_ingreso'];

            if ($this->rolloTela->crear()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/rollos_tela?msg=creado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/rollos_tela?msg=error");
            }
        }
    }

    public function editar($id = null) {
        if ($id == null) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/rollos_tela");
            exit();
        }

        if ($this->rolloTela->obtenerPorId($id)) {
            // Obtener tipos de tela para el selector
            $stmtTelas = $this->tipoTela->leerTodos();
            $telas = $stmtTelas->fetchAll();

            require_once 'views/layouts/header.php';
            require_once 'views/rollos_tela/editar.php';
            require_once 'views/layouts/footer.php';
        } else {
            echo "Rollo no encontrado.";
        }
    }

    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->rolloTela->id_rollo = $id;
            $this->rolloTela->id_tipo_tela = $_POST['id_tipo_tela'];
            $this->rolloTela->cantidad_inicial = $_POST['cantidad_inicial'];
            $this->rolloTela->rollos_disponibles = $_POST['rollos_disponibles'];
            $this->rolloTela->fecha_ingreso = $_POST['fecha_ingreso'];

            if ($this->rolloTela->actualizar()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/rollos_tela?msg=actualizado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/rollos_tela?msg=error");
            }
        }
    }

    public function eliminar($id) {
        if ($id != null) {
            $resultado = $this->rolloTela->eliminar($id);
            if ($resultado === true) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/rollos_tela?msg=eliminado");
            } elseif ($resultado === 'en_uso') {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/rollos_tela?msg=error_en_uso");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/rollos_tela?msg=error");
            }
        }
    }
}
?>
