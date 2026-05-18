<div class="main-content">
    <div class="page-header">
        <div>
            <h1>Entregas de Producción</h1>
            <p>Registra las piezas terminadas por las costureras.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/defectos/crear"; ?>" class="btn" style="background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA;">
                <i class="fa-solid fa-triangle-exclamation"></i> Registrar Mermas
            </a>
            <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/entregas/crear"; ?>" class="btn btn-primary">
                <i class="fa-solid fa-truck-ramp-box"></i> Registrar Entrega
            </a>
        </div>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'creado'): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> Entrega registrada en el sistema.
            </div>
        <?php elseif ($_GET['msg'] == 'defecto_creado'): ?>
            <div class="alert alert-error" style="background: #FEF2F2; color: #DC2626; border-color: #FECACA;">
                <i class="fa-solid fa-triangle-exclamation"></i> Mermas / Defectos registrados en el sistema.
            </div>
        <?php elseif ($_GET['msg'] == 'actualizado'): ?>
            <div class="alert alert-info">
                <i class="fa-solid fa-circle-info"></i> Registro actualizado exitosamente.
            </div>
        <?php elseif ($_GET['msg'] == 'eliminado'): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-trash-can"></i> Entrega eliminada del registro.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
        <div style="position: relative; width: 100%; max-width: 350px;">
            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
            <input type="text" id="searchInput" class="form-control" style="padding-left: 2.5rem; border-radius: 20px; background: #fff;" placeholder="Buscar fecha, costurera o producto...">
        </div>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Costurera</th>
                    <th>Producto Entregado</th>
                    <th>Piezas Entregadas</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($entregas)): ?>
                    <tr>
                        <td colspan="4" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                            <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"><i class="fa-solid fa-box-open"></i></div>
                            Aún no hay entregas de producción registradas.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($entregas as $e): ?>
                        <tr>
                            <td>
                                <span style="color: var(--text-muted);"><i class="fa-regular fa-clock"></i> <?php echo date("d/m/Y H:i", strtotime($e['fecha_entrega'])); ?></span>
                            </td>
                            <td style="font-weight: 500;">
                                <?php if($e['es_arreglo'] == 1): ?>
                                    <i class="fa-solid fa-screwdriver-wrench" style="color: #DC2626; margin-right: 5px;"></i> 
                                    <span style="color: #DC2626; font-weight: 700;"><?php echo htmlspecialchars($e['nombre_costurera']); ?></span>
                                    <span style="background: #FEF2F2; color: #DC2626; padding: 0.1rem 0.4rem; border-radius: 4px; font-size: 0.75rem; margin-left: 5px; border: 1px solid #FECACA;">Arreglo</span>
                                <?php else: ?>
                                    <i class="fa-solid fa-user" style="color: var(--primary); margin-right: 5px;"></i> 
                                    <?php echo htmlspecialchars($e['nombre_costurera']); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($e['nombre_producto']); ?>
                            </td>
                            <td>
                                <span style="background: #D1FAE5; color: #047857; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 600;">
                                    <?php echo $e['piezas_buenas']; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('table tbody tr');
    
    rows.forEach(row => {
        if (row.querySelector('td[colspan]')) return;
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>
