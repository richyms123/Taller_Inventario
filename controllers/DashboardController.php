<?php
class DashboardController {
    public function index() {
        session_start();
        
        $baseUrl = "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario";

        // Verificar si el usuario está logueado, si no, redirigirlo al login
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: " . $baseUrl . "/login");
            exit();
        }

        require_once 'config/database.php';
        $database = new Database();
        $db = $database->getConnection();

        // 1. Total de Rollos en Almacén
        $stmtRollos = $db->query("SELECT COUNT(*) as total_rollos FROM rollos_tela");
        $totalRollos = $stmtRollos->fetch(PDO::FETCH_ASSOC)['total_rollos'];

        // 2. Asignaciones Activas
        $stmtAsig = $db->query("SELECT COUNT(*) as activas FROM asignaciones_trabajo WHERE estado != 'Terminado'");
        $asignacionesActivas = $stmtAsig->fetch(PDO::FETCH_ASSOC)['activas'];

        // 3. Entregas (Piezas) Hoy
        $stmtEntregas = $db->query("SELECT COALESCE(SUM(cantidad_buenas), 0) as piezas_hoy FROM entregas_produccion WHERE DATE(fecha_entrega) = CURDATE()");
        $piezasHoy = $stmtEntregas->fetch(PDO::FETCH_ASSOC)['piezas_hoy'];

        require_once 'views/layouts/header.php';
        require_once 'views/dashboard/index.php';
        require_once 'views/layouts/footer.php';
    }
}
?>
