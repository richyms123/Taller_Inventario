<div class="main-content">
    <div class="page-header" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1>Reporte de Producción Diaria</h1>
            <p>Conoce exactamente cuántas piezas fabricó cada costurera en un día específico.</p>
        </div>
        
        <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/reportes"; ?>" method="GET" style="display: flex; gap: 10px; align-items: center; background: white; padding: 10px 15px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <label style="margin: 0; font-weight: 600; color: var(--text-main);">Fecha:</label>
            <input type="date" name="fecha" value="<?php echo htmlspecialchars($fechaFiltro); ?>" class="form-control" style="width: auto; padding: 0.5rem 1rem;" onchange="this.form.submit()">
        </form>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card" style="background: linear-gradient(135deg, #10B981, #059669); color: white;">
            <h3 style="margin: 0; font-size: 1.2rem; font-weight: 500; opacity: 0.9;">Total Piezas Buenas Hoy</h3>
            <div style="font-size: 3rem; font-weight: 700; margin-top: 10px;"><?php echo $totalDiaBuenas; ?></div>
        </div>
        <div class="card" style="background: linear-gradient(135deg, #EF4444, #DC2626); color: white;">
            <h3 style="margin: 0; font-size: 1.2rem; font-weight: 500; opacity: 0.9;">Total Mermas / Defectuosas</h3>
            <div style="font-size: 3rem; font-weight: 700; margin-top: 10px;"><?php echo $totalDiaMalas; ?></div>
        </div>
    </div>

    <div class="card">
        <h2 style="margin-top: 0; border-bottom: 2px solid var(--border); padding-bottom: 1rem; margin-bottom: 1rem;">Detalle por Costurera (<?php echo date("d/m/Y", strtotime($fechaFiltro)); ?>)</h2>
        
        <?php if (empty($reporte)): ?>
            <div style="padding: 3rem; text-align: center; color: var(--text-muted);">
                <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"><i class="fa-solid fa-mug-hot"></i></div>
                No se registraron entregas de producción en esta fecha.
            </div>
        <?php else: ?>
            <table class="table" style="box-shadow: none;">
                <thead>
                    <tr style="background: var(--bg-body);">
                        <th>Costurera</th>
                        <th>Producto Trabajado</th>
                        <th style="text-align: center;">Piezas Buenas</th>
                        <th style="text-align: center;">Piezas Malas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reporte as $r): ?>
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
                            <td style="text-align: center;">
                                <?php if($r['total_malas'] > 0): ?>
                                    <span style="background: #FEE2E2; color: #DC2626; padding: 0.3rem 1rem; border-radius: 20px; font-weight: 700; font-size: 1.1rem;">
                                        -<?php echo $r['total_malas']; ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: var(--text-muted);">0</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
