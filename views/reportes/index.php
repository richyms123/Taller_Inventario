<div class="main-content">
    <div class="page-header" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1>Reporte de Producción Diaria</h1>
            <p>Conoce exactamente cuántas piezas se fabricaron y cuántas mermas se registraron.</p>
        </div>
        
        <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/reportes"; ?>" method="GET" style="display: flex; gap: 10px; align-items: center; background: white; padding: 10px 15px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <label style="margin: 0; font-weight: 600; color: var(--text-main);">Fecha:</label>
            <input type="date" name="fecha" value="<?php echo htmlspecialchars($fechaFiltro); ?>" class="form-control" style="width: auto; padding: 0.5rem 1rem;" onchange="this.form.submit()">
        </form>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card" style="background: linear-gradient(135deg, #10B981, #059669); color: white;">
            <h3 style="margin: 0; font-size: 1.2rem; font-weight: 500; opacity: 0.9;">Total Piezas Buenas Hoy</h3>
            <div style="font-size: 3rem; font-weight: 700; margin-top: 10px;"><?php echo $totalDiaBuenas; ?></div>
            <div style="font-size: 0.85rem; opacity: 0.8; margin-top: 5px;">(Mermas ya descontadas)</div>
        </div>
        <div class="card" style="background: linear-gradient(135deg, #EF4444, #DC2626); color: white;">
            <h3 style="margin: 0; font-size: 1.2rem; font-weight: 500; opacity: 0.9;">Total Mermas / Defectuosas</h3>
            <div style="font-size: 3rem; font-weight: 700; margin-top: 10px;"><?php echo $totalDiaMalas; ?></div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start;">
        <!-- Tabla de Producción (Buenas) -->
        <div class="card">
            <h2 style="margin-top: 0; border-bottom: 2px solid var(--border); padding-bottom: 1rem; margin-bottom: 1rem; color: #047857;">Producción por Costurera (<?php echo date("d/m/Y", strtotime($fechaFiltro)); ?>)</h2>
            
            <?php if (empty($reporteBuenas)): ?>
                <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
                    <div style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"><i class="fa-solid fa-mug-hot"></i></div>
                    No se registraron entregas de piezas buenas en esta fecha.
                </div>
            <?php else: ?>
                <table class="table" style="box-shadow: none;">
                    <thead>
                        <tr style="background: var(--bg-body);">
                            <th>Costurera</th>
                            <th>Producto Fabricado</th>
                            <th style="text-align: center;">Piezas Buenas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reporteBuenas as $r): ?>
                            <tr>
                                <td style="font-weight: 600; font-size: 1.05rem;">
                                    <i class="fa-solid fa-user-check" style="color: var(--primary); margin-right: 8px;"></i>
                                    <?php echo htmlspecialchars($r['nombre_completo']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($r['nombre_producto']); ?></td>
                                <td style="text-align: center;">
                                    <span style="background: #D1FAE5; color: #047857; padding: 0.3rem 1rem; border-radius: 20px; font-weight: 700; font-size: 1.1rem;">
                                        +<?php echo $r['total_buenas']; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Tabla de Defectos (Malas) -->
        <div class="card">
            <h2 style="margin-top: 0; border-bottom: 2px solid var(--border); padding-bottom: 1rem; margin-bottom: 1rem; color: #DC2626;">Mermas Registradas</h2>
            
            <?php if (empty($reporteDefectos)): ?>
                <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
                    <div style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"><i class="fa-solid fa-check-double"></i></div>
                    Excelente. Cero defectos.
                </div>
            <?php else: ?>
                <table class="table" style="box-shadow: none;">
                    <thead>
                        <tr style="background: var(--bg-body);">
                            <th>Producto</th>
                            <th style="text-align: center;">Malas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reporteDefectos as $d): ?>
                            <tr>
                                <td style="font-weight: 500;">
                                    <?php echo htmlspecialchars($d['nombre_producto']); ?>
                                </td>
                                <td style="text-align: center;">
                                    <span style="background: #FEE2E2; color: #DC2626; padding: 0.3rem 1rem; border-radius: 20px; font-weight: 700; font-size: 1.1rem;">
                                        -<?php echo $d['total_malas']; ?>
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
