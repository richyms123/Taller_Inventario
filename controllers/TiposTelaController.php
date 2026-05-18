<?php
require_once 'models/TipoTela.php';

class TiposTelaController {
    private $db;
    private $tipoTela;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/login");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->tipoTela = new TipoTela($this->db);
    }

    public function index() {
        $stmt = $this->tipoTela->leerTodos();
        $telas = $stmt->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/tipos_tela/index.php';
        require_once 'views/layouts/footer.php';
    }

    public function crear() {
        require_once 'views/layouts/header.php';
        require_once 'views/tipos_tela/crear.php';
        require_once 'views/layouts/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->tipoTela->nombre_tela = $_POST['nombre_tela'];
            $this->tipoTela->tipo_maquina = isset($_POST['tipo_maquina']) ? $_POST['tipo_maquina'] : 'Ambos';

            if ($this->tipoTela->crear()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/tipos_tela?msg=creado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/tipos_tela?msg=error_duplicado");
            }
        }
    }

    public function editar($id = null) {
        if ($id == null) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/tipos_tela");
            exit();
        }

        if ($this->tipoTela->obtenerPorId($id)) {
            require_once 'views/layouts/header.php';
            require_once 'views/tipos_tela/editar.php';
            require_once 'views/layouts/footer.php';
        } else {
            echo "Tipo de tela no encontrado.";
        }
    }

    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->tipoTela->id_tipo_tela = $id;
            $this->tipoTela->nombre_tela = $_POST['nombre_tela'];
            $this->tipoTela->tipo_maquina = isset($_POST['tipo_maquina']) ? $_POST['tipo_maquina'] : 'Ambos';

            if ($this->tipoTela->actualizar()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/tipos_tela?msg=actualizado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/tipos_tela?msg=error_duplicado");
            }
        }
    }

    public function eliminar($id) {
        if ($id != null) {
            $resultado = $this->tipoTela->eliminar($id);
            if ($resultado === true) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/tipos_tela?msg=eliminado");
            } elseif ($resultado === 'en_uso') {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/tipos_tela?msg=error_en_uso");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/tipos_tela?msg=error");
            }
        }
    }
}
?>
