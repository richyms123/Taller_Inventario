<?php
require_once 'models/Producto.php';

class ProductosController {
    private $db;
    private $producto;

    public function __construct() {
        // Verificar sesión en todas las rutas de este controlador
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/login");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->producto = new Producto($this->db);
    }

    // Listar todos los productos
    public function index() {
        $stmt = $this->producto->leerTodos();
        $productos = $stmt->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/productos/index.php';
        require_once 'views/layouts/footer.php';
    }

    // Mostrar formulario para crear
    public function crear() {
        require_once 'views/layouts/header.php';
        require_once 'views/productos/crear.php';
        require_once 'views/layouts/footer.php';
    }

    // Procesar creación
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->producto->nombre_producto = $_POST['nombre_producto'];
            $this->producto->descripcion = $_POST['descripcion'];
            $this->producto->precio_maquila = $_POST['precio_maquila'];
            $this->producto->tipo_maquina = isset($_POST['tipo_maquina']) ? $_POST['tipo_maquina'] : 'Ambos';

            if ($this->producto->crear()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/productos?msg=creado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/productos?msg=error_duplicado");
            }
        }
    }

    // Mostrar formulario para editar
    public function editar($id = null) {
        if ($id == null) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/productos");
            exit();
        }

        if ($this->producto->obtenerPorId($id)) {
            // El objeto $this->producto ya tiene los datos cargados
            require_once 'views/layouts/header.php';
            require_once 'views/productos/editar.php';
            require_once 'views/layouts/footer.php';
        } else {
            echo "Producto no encontrado.";
        }
    }

    // Procesar actualización
    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->producto->id_producto = $id;
            $this->producto->nombre_producto = $_POST['nombre_producto'];
            $this->producto->descripcion = $_POST['descripcion'];
            $this->producto->precio_maquila = $_POST['precio_maquila'];
            $this->producto->tipo_maquina = isset($_POST['tipo_maquina']) ? $_POST['tipo_maquina'] : 'Ambos';

            if ($this->producto->actualizar()) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/productos?msg=actualizado");
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/productos?msg=error_duplicado");
            }
        }
    }

    // Procesar eliminación (borrado lógico)
    public function eliminar($id) {
        if ($id != null) {
            if ($this->producto->eliminar($id)) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/productos?msg=eliminado");
            } else {
                echo "Error al eliminar el producto.";
            }
        }
    }
}
?>
