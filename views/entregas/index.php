<div class="main-content">
    <div class="page-header">
        <div>
            <h1>Entregas de Producción</h1>
            <p>Registra las piezas terminadas por las costureras.</p>
        </div>
        <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas/crear"; ?>" class="btn btn-primary">
            <i class="fa-solid fa-truck-ramp-box"></i> Registrar Entrega
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'creado'): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> Entrega registrada en el sistema.
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
                    <th>Costurera (Asignación)</th>
                    <th>Piezas Buenas</th>
                    <th>Piezas Malas</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($entregas)): ?>
                    <tr>
                        <td colspan="6" style="padding: 3rem; text-align: center; color: var(--text-muted);">
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
                                <i class="fa-solid fa-user" style="color: var(--primary); margin-right: 5px;"></i> 
                                <?php echo htmlspecialchars($e['nombre_costurera']); ?>
                                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: normal;">
                                    Haciendo: <?php echo htmlspecialchars($e['nombre_producto']); ?> (Asig #<?php echo $e['id_asignacion']; ?>)
                                </div>
                            </td>
                            <td>
                                <span style="background: #D1FAE5; color: #047857; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 600;">
                                    <?php echo $e['piezas_buenas']; ?>
                                </span>
                            </td>
                            <td>
                                <?php if($e['piezas_malas'] > 0): ?>
                                    <span style="background: #FEE2E2; color: #DC2626; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 600;">
                                        <?php echo $e['piezas_malas']; ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: var(--text-muted);">-</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas/editar/" . $e['id_entrega']; ?>" class="btn-action edit" title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas/eliminar/" . $e['id_entrega']; ?>" class="btn-action delete" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este registro de entrega?');">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
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
