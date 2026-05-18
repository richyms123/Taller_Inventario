<?php
class DashboardController {
    public function index() {
        session_start();
        
        $baseUrl = "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main";

        // Verificar si el usuario está logueado, si no, redirigirlo al login
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: " . $baseUrl . "/login");
            exit();
        }

        require_once 'config/database.php';
        $database = new Database();
        $db = $database->getConnection();

        // Obtener la fecha del filtro o usar la fecha actual
        $fechaFiltro = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

        // 1. Total de Rollos en Almacén
        $stmtRollos = $db->query("SELECT COUNT(*) as total_rollos FROM rollos_tela");
        $totalRollos = $stmtRollos->fetch(PDO::FETCH_ASSOC)['total_rollos'];

        // 2. Asignaciones Hoy
        $stmtAsig = $db->prepare("SELECT COUNT(*) as activas FROM asignaciones_trabajo WHERE DATE(fecha_asignacion) = :fecha");
        $stmtAsig->bindParam(':fecha', $fechaFiltro);
        $stmtAsig->execute();
        $asignacionesActivas = $stmtAsig->fetch(PDO::FETCH_ASSOC)['activas'];

        // 3. Entregas (Piezas) Hoy
        $stmtEntregas = $db->prepare("SELECT COALESCE(SUM(cantidad_buenas), 0) as piezas_hoy FROM entregas_produccion WHERE DATE(fecha_entrega) = :fecha");
        $stmtEntregas->bindParam(':fecha', $fechaFiltro);
        $stmtEntregas->execute();
        $piezasHoy = $stmtEntregas->fetch(PDO::FETCH_ASSOC)['piezas_hoy'];

        // --- LÓGICA DE REPORTE DIARIO ---
        $queryBuenas = "SELECT IFNULL(c.nombre_completo, 'Taller (Arreglo)') as nombre_completo, p.nombre_producto, 
                               SUM(e.cantidad_buenas) as total_buenas
                        FROM entregas_produccion e
                        LEFT JOIN costureras c ON e.id_costurera = c.id_costurera
                        JOIN productos p ON e.id_producto = p.id_producto
                        WHERE DATE(e.fecha_entrega) = :fecha
                        GROUP BY c.id_costurera, p.id_producto
                        ORDER BY c.nombre_completo ASC";
                  
        $stmtBuenas = $db->prepare($queryBuenas);
        $stmtBuenas->bindParam(':fecha', $fechaFiltro);
        $stmtBuenas->execute();
        $reporteBuenas = $stmtBuenas->fetchAll(PDO::FETCH_ASSOC);

        $queryDefectos = "SELECT p.id_producto, p.nombre_producto, 
                                 SUM(d.cantidad) as total_malas
                          FROM defectos_produccion d
                          JOIN productos p ON d.id_producto = p.id_producto
                          WHERE DATE(d.fecha_registro) = :fecha
                          GROUP BY p.id_producto
                          ORDER BY p.nombre_producto ASC";

        $stmtDefectos = $db->prepare($queryDefectos);
        $stmtDefectos->bindParam(':fecha', $fechaFiltro);
        $stmtDefectos->execute();
        $reporteDefectosRaw = $stmtDefectos->fetchAll(PDO::FETCH_ASSOC);

        $queryArreglos = "SELECT id_producto, SUM(cantidad_buenas) as total_arreglos
                          FROM entregas_produccion
                          WHERE DATE(fecha_entrega) = :fecha AND es_arreglo = 1
                          GROUP BY id_producto";
        $stmtArreglos = $db->prepare($queryArreglos);
        $stmtArreglos->bindParam(':fecha', $fechaFiltro);
        $stmtArreglos->execute();
        $arreglos = [];
        while($row = $stmtArreglos->fetch(PDO::FETCH_ASSOC)) {
            $arreglos[$row['id_producto']] = $row['total_arreglos'];
        }

        $reporteDefectos = [];
        $totalDiaMalas = 0;

        foreach($reporteDefectosRaw as $d) {
            $id_prod = $d['id_producto'];
            $malas = $d['total_malas'];
            if (isset($arreglos[$id_prod])) {
                $malas -= $arreglos[$id_prod];
            }
            if ($malas > 0) {
                $d['total_malas'] = $malas;
                $reporteDefectos[] = $d;
                $totalDiaMalas += $malas;
            }
        }

        $totalDiaBuenas = 0;
        foreach($reporteBuenas as $r) {
            $totalDiaBuenas += $r['total_buenas'];
        }

        $totalDiaBuenas = $totalDiaBuenas - $totalDiaMalas;
        if ($totalDiaBuenas < 0) {
            $totalDiaBuenas = 0;
        }

        require_once 'views/layouts/header.php';
        require_once 'views/dashboard/index.php';
        require_once 'views/layouts/footer.php';
    }
}
?>
