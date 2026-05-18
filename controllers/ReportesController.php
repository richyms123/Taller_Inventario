<?php
class ReportesController {
    public function index() {
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/dashboard");
        exit();
    }

    public function semanal() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/login");
            exit();
        }

        require_once 'config/database.php';
        $database = new Database();
        $db = $database->getConnection();

        $semanaFiltro = isset($_GET['semana']) ? $_GET['semana'] : date('Y-\WW');
        $dto = new DateTime();
        $dto->setISODate((int)substr($semanaFiltro, 0, 4), (int)substr($semanaFiltro, 6));
        $fechaInicio = $dto->format('Y-m-d'); // Lunes
        $dto->modify('+5 days');
        $fechaFin = $dto->format('Y-m-d'); // Sábado

        // 1. Producción agrupada (Overlock/Recta/Arreglos)
        $queryBuenas = "SELECT IFNULL(c.nombre_completo, 'Taller (Arreglo)') as nombre_completo, 
                               IFNULL(c.tipo_maquina, 'Arreglo') as tipo_maquina,
                               p.nombre_producto, SUM(e.cantidad_buenas) as total_buenas
                        FROM entregas_produccion e
                        LEFT JOIN costureras c ON e.id_costurera = c.id_costurera
                        JOIN productos p ON e.id_producto = p.id_producto
                        WHERE DATE(e.fecha_entrega) >= :fecha_inicio AND DATE(e.fecha_entrega) <= :fecha_fin
                        GROUP BY c.id_costurera, p.id_producto
                        ORDER BY c.nombre_completo ASC";
        $stmtBuenas = $db->prepare($queryBuenas);
        $stmtBuenas->bindParam(':fecha_inicio', $fechaInicio);
        $stmtBuenas->bindParam(':fecha_fin', $fechaFin);
        $stmtBuenas->execute();
        $reporteBuenas = $stmtBuenas->fetchAll(PDO::FETCH_ASSOC);

        // 2. Mermas y Arreglos semanales
        $queryDefectos = "SELECT p.id_producto, p.nombre_producto, SUM(d.cantidad) as total_malas
                          FROM defectos_produccion d
                          JOIN productos p ON d.id_producto = p.id_producto
                          WHERE DATE(d.fecha_registro) >= :fecha_inicio AND DATE(d.fecha_registro) <= :fecha_fin
                          GROUP BY p.id_producto";
        $stmtDefectos = $db->prepare($queryDefectos);
        $stmtDefectos->bindParam(':fecha_inicio', $fechaInicio);
        $stmtDefectos->bindParam(':fecha_fin', $fechaFin);
        $stmtDefectos->execute();
        $reporteDefectosRaw = $stmtDefectos->fetchAll(PDO::FETCH_ASSOC);

        $queryArreglos = "SELECT id_producto, SUM(cantidad_buenas) as total_arreglos
                          FROM entregas_produccion
                          WHERE DATE(fecha_entrega) >= :fecha_inicio AND DATE(fecha_entrega) <= :fecha_fin 
                          AND es_arreglo = 1
                          GROUP BY id_producto";
        $stmtArreglos = $db->prepare($queryArreglos);
        $stmtArreglos->bindParam(':fecha_inicio', $fechaInicio);
        $stmtArreglos->bindParam(':fecha_fin', $fechaFin);
        $stmtArreglos->execute();
        $arreglos = [];
        while($row = $stmtArreglos->fetch(PDO::FETCH_ASSOC)) {
            $arreglos[$row['id_producto']] = $row['total_arreglos'];
        }

        $totalSemanaMalas = 0;
        foreach($reporteDefectosRaw as $d) {
            $malas = $d['total_malas'];
            if (isset($arreglos[$d['id_producto']])) {
                $malas -= $arreglos[$d['id_producto']];
            }
            if ($malas > 0) {
                $totalSemanaMalas += $malas;
            }
        }

        $totalSemanaBuenas = 0;
        $reporteOverlock = [];
        $reporteRecta = [];
        foreach($reporteBuenas as $r) {
            $totalSemanaBuenas += $r['total_buenas'];
            if ($r['tipo_maquina'] == 'Overlock') {
                $reporteOverlock[] = $r;
            } elseif ($r['tipo_maquina'] == 'Recta') {
                $reporteRecta[] = $r;
            }
            // Ignoramos arreglos para las tablas de costureras
        }

        $totalSemanaBuenas = $totalSemanaBuenas - $totalSemanaMalas;
        if ($totalSemanaBuenas < 0) $totalSemanaBuenas = 0;

        // 3. Datos para la Gráfica (Lunes a Sábado)
        $queryGrafica = "SELECT DATE(e.fecha_entrega) as fecha, 
                                c.tipo_maquina, 
                                SUM(e.cantidad_buenas) as total
                         FROM entregas_produccion e
                         JOIN costureras c ON e.id_costurera = c.id_costurera
                         WHERE DATE(e.fecha_entrega) >= :fecha_inicio AND DATE(e.fecha_entrega) <= :fecha_fin
                         GROUP BY DATE(e.fecha_entrega), c.tipo_maquina";
        $stmtGrafica = $db->prepare($queryGrafica);
        $stmtGrafica->bindParam(':fecha_inicio', $fechaInicio);
        $stmtGrafica->bindParam(':fecha_fin', $fechaFin);
        $stmtGrafica->execute();
        $graficaRaw = $stmtGrafica->fetchAll(PDO::FETCH_ASSOC);

        // Inicializar datos para los 6 días
        $labels = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $dataOverlock = [0, 0, 0, 0, 0, 0];
        $dataRecta = [0, 0, 0, 0, 0, 0];

        // Mapear fecha a índice de día (0 = Lunes, 5 = Sábado)
        foreach ($graficaRaw as $g) {
            $fechaObj = new DateTime($g['fecha']);
            $diaSemana = (int)$fechaObj->format('N') - 1; // 1 (Lunes) -> 0, 6 (Sábado) -> 5
            if ($diaSemana >= 0 && $diaSemana <= 5) {
                if ($g['tipo_maquina'] == 'Overlock') {
                    $dataOverlock[$diaSemana] += $g['total'];
                } elseif ($g['tipo_maquina'] == 'Recta') {
                    $dataRecta[$diaSemana] += $g['total'];
                }
            }
        }

        require_once 'views/layouts/header.php';
        require_once 'views/reportes/semanal.php';
        require_once 'views/layouts/footer.php';
    }
}
?>
