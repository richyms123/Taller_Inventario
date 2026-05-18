<?php
require_once 'models/Asignacion.php';
require_once 'models/Costurera.php';
require_once 'models/TipoTela.php';
require_once 'models/RolloTela.php';

class AsignacionesController {
    private $db;
    private $asignacion;
    private $costurera;
    private $tipoTela;
    private $rolloTela;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/login");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->asignacion = new Asignacion($this->db);
        $this->costurera = new Costurera($this->db);
        $this->tipoTela = new TipoTela($this->db);
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
        $tipos_tela = $this->tipoTela->leerTodos()->fetchAll();

        require_once 'views/layouts/header.php';
        require_once 'views/asignaciones/crear.php';
        require_once 'views/layouts/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_costurera = $_POST['id_costurera'];
            $id_tipo_tela = $_POST['id_tipo_tela'];
            $cantidad_requerida = isset($_POST['rollos_utilizados']) ? (int)$_POST['rollos_utilizados'] : 0;
            $fecha_asignacion = $_POST['fecha_asignacion'];

            if ($cantidad_requerida <= 0) {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/asignaciones/crear?msg=error");
                exit();
            }

            try {
                // Iniciar transacción
                $this->db->beginTransaction();

                // Buscar rollos antiguos con disponibilidad
                $query = "SELECT id_rollo, rollos_disponibles FROM rollos_tela 
                          WHERE id_tipo_tela = :id_tipo_tela AND rollos_disponibles > 0 
                          ORDER BY fecha_ingreso ASC, id_rollo ASC";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id_tipo_tela', $id_tipo_tela);
                $stmt->execute();
                
                $rollos_candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $cantidad_restante = $cantidad_requerida;

                foreach ($rollos_candidatos as $rollo) {
                    if ($cantidad_restante <= 0) break;

                    $disponible = (int)$rollo['rollos_disponibles'];
                    $usar = min($cantidad_restante, $disponible);

                    // 1. Descontar del inventario
                    $nuevo_disponible = $disponible - $usar;
                    $updateStmt = $this->db->prepare("UPDATE rollos_tela SET rollos_disponibles = :nd WHERE id_rollo = :id");
                    $updateStmt->bindParam(':nd', $nuevo_disponible);
                    $updateStmt->bindParam(':id', $rollo['id_rollo']);
                    $updateStmt->execute();

                    // 2. Crear la asignación
                    $this->asignacion->id_costurera = $id_costurera;
                    $this->asignacion->id_rollo = $rollo['id_rollo'];
                    $this->asignacion->rollos_utilizados = $usar;
                    $this->asignacion->cantidad_asignada = $usar;
                    $this->asignacion->fecha_asignacion = $fecha_asignacion;
                    $this->asignacion->crear();

                    $cantidad_restante -= $usar;
                }

                // Si no se cubrió toda la cantidad requerida, lanzamos error y hacemos rollback
                if ($cantidad_restante > 0) {
                    $this->db->rollBack();
                    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/asignaciones/crear?msg=stock_insuficiente");
                    exit();
                }

                $this->db->commit();
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/asignaciones?msg=creado");

            } catch (Exception $e) {
                $this->db->rollBack();
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/asignaciones?msg=error");
            }
        }
    }
}
?>
