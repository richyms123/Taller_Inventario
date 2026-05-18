<div class="main-content">
    <div class="page-header" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1>Reporte Semanal de Producción</h1>
            <p>Evalúa el rendimiento de la semana agrupado por Overlock y Recta.</p>
        </div>
        
        <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/reportes/semanal"; ?>" method="GET" style="display: flex; gap: 10px; align-items: center; background: white; padding: 10px 15px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <label style="margin: 0; font-weight: 600; color: var(--text-main);">Semana:</label>
            <input type="week" name="semana" value="<?php echo htmlspecialchars($semanaFiltro); ?>" class="form-control" style="width: auto; padding: 0.5rem 1rem;" onchange="this.form.submit()" required>
        </form>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card" style="background: linear-gradient(135deg, #10B981, #059669); color: white;">
            <h3 style="margin: 0; font-size: 1.2rem; font-weight: 500; opacity: 0.9;">Total Piezas Buenas Semana</h3>
            <div style="font-size: 3rem; font-weight: 700; margin-top: 10px;"><?php echo $totalSemanaBuenas; ?></div>
            <div style="font-size: 0.85rem; opacity: 0.8; margin-top: 5px;">(Mermas ya descontadas)</div>
        </div>
        <div class="card" style="background: linear-gradient(135deg, #EF4444, #DC2626); color: white;">
            <h3 style="margin: 0; font-size: 1.2rem; font-weight: 500; opacity: 0.9;">Total Mermas / Defectuosas Semana</h3>
            <div style="font-size: 3rem; font-weight: 700; margin-top: 10px;"><?php echo $totalSemanaMalas; ?></div>
        </div>
    </div>

    <!-- Gráfica Semanal -->
    <div class="card" style="margin-bottom: 2rem;">
        <h2 style="margin-top: 0; border-bottom: 2px solid var(--border); padding-bottom: 1rem; margin-bottom: 1rem; color: var(--text-main);">Evolución Diaria (Lunes a Sábado)</h2>
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="graficaSemanal"></canvas>
        </div>
    </div>

    <!-- Tablas por Costurera -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; align-items: start;">
        
        <!-- Tabla Overlock -->
        <div class="card">
            <h2 style="margin-top: 0; border-bottom: 2px solid var(--border); padding-bottom: 1rem; margin-bottom: 1rem; color: #4338CA;">
                <i class="fa-solid fa-gear"></i> Producción - Overlock
            </h2>
            
            <?php if (empty($reporteOverlock)): ?>
                <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
                    <div style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"><i class="fa-solid fa-mug-hot"></i></div>
                    Sin entregas en Overlock esta semana.
                </div>
            <?php else: ?>
                <table class="table" style="box-shadow: none;">
                    <thead>
                        <tr style="background: var(--bg-body);">
                            <th>Costurera</th>
                            <th>Producto Fabricado</th>
                            <th style="text-align: center;">Buenas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reporteOverlock as $r): ?>
                            <tr>
                                <td style="font-weight: 600; font-size: 1.05rem;">
                                    <?php echo htmlspecialchars($r['nombre_completo']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($r['nombre_producto']); ?></td>
                                <td style="text-align: center;">
                                    <span style="background: #E0E7FF; color: #4338CA; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 700;">
                                        +<?php echo $r['total_buenas']; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Tabla Recta -->
        <div class="card">
            <h2 style="margin-top: 0; border-bottom: 2px solid var(--border); padding-bottom: 1rem; margin-bottom: 1rem; color: #BE185D;">
                <i class="fa-solid fa-gear"></i> Producción - Recta
            </h2>
            
            <?php if (empty($reporteRecta)): ?>
                <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
                    <div style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"><i class="fa-solid fa-mug-hot"></i></div>
                    Sin entregas en Recta esta semana.
                </div>
            <?php else: ?>
                <table class="table" style="box-shadow: none;">
                    <thead>
                        <tr style="background: var(--bg-body);">
                            <th>Costurera</th>
                            <th>Producto Fabricado</th>
                            <th style="text-align: center;">Buenas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reporteRecta as $r): ?>
                            <tr>
                                <td style="font-weight: 600; font-size: 1.05rem;">
                                    <?php echo htmlspecialchars($r['nombre_completo']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($r['nombre_producto']); ?></td>
                                <td style="text-align: center;">
                                    <span style="background: #FCE7F3; color: #BE185D; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 700;">
                                        +<?php echo $r['total_buenas']; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('graficaSemanal').getContext('2d');
    
    const labels = <?php echo json_encode($labels); ?>;
    const dataOverlock = <?php echo json_encode($dataOverlock); ?>;
    const dataRecta = <?php echo json_encode($dataRecta); ?>;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Producción Overlock',
                    data: dataOverlock,
                    backgroundColor: '#4338CA',
                    borderRadius: 4,
                },
                {
                    label: 'Producción Recta',
                    data: dataRecta,
                    backgroundColor: '#BE185D',
                    borderRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
});
</script>
