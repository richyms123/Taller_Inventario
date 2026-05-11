<?php
class ReportesController {
    public function index() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/login");
            exit();
        }

        require_once 'config/database.php';
        $database = new Database();
        $db = $database->getConnection();

        // Obtener la fecha del filtro o usar la fecha actual
        $fechaFiltro = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

        // Consulta para agrupar por costurera y producto en la fecha seleccionada
        $query = "SELECT c.nombre_completo, p.nombre_producto, 
                         SUM(e.cantidad_buenas) as total_buenas, 
                         SUM(e.cantidad_defectuosas) as total_malas
                  FROM entregas_produccion e
                  JOIN asignaciones_trabajo a ON e.id_asignacion = a.id_asignacion
                  JOIN costureras c ON a.id_costurera = c.id_costurera
                  JOIN productos p ON a.id_producto = p.id_producto
                  WHERE DATE(e.fecha_entrega) = :fecha
                  GROUP BY c.id_costurera, p.id_producto
                  ORDER BY c.nombre_completo ASC";
                  
        $stmt = $db->prepare($query);
        $stmt->bindParam(':fecha', $fechaFiltro);
        $stmt->execute();
        $reporte = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calcular totales del día
        $totalDiaBuenas = 0;
        $totalDiaMalas = 0;
        foreach($reporte as $r) {
            $totalDiaBuenas += $r['total_buenas'];
            $totalDiaMalas += $r['total_malas'];
        }

        require_once 'views/layouts/header.php';
        require_once 'views/reportes/index.php';
        require_once 'views/layouts/footer.php';
    }
}
?>
