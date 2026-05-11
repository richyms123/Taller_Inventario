<div class="main-content">
    <div class="page-header">
        <div>
            <h1>Asignaciones de Trabajo</h1>
            <p>El "cuaderno digital": registra qué trabajo y tela le entregaste a cada costurera.</p>
        </div>
        <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones/crear"; ?>" class="btn btn-primary">
            <i class="fa-solid fa-clipboard-list"></i> Nueva Asignación
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'creado'): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> Asignación registrada exitosamente.
            </div>
        <?php elseif ($_GET['msg'] == 'actualizado'): ?>
            <div class="alert alert-info">
                <i class="fa-solid fa-circle-info"></i> Asignación actualizada exitosamente.
            </div>
        <?php elseif ($_GET['msg'] == 'eliminado'): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-trash-can"></i> Asignación eliminada.
            </div>
        <?php elseif ($_GET['msg'] == 'error_en_uso'): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-shield-halved"></i> Error: Esta asignación tiene entregas vinculadas y no se puede borrar.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
        <div style="position: relative; width: 100%; max-width: 350px;">
            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
            <input type="text" id="searchInput" class="form-control" style="padding-left: 2.5rem; border-radius: 20px; background: #fff;" placeholder="Buscar costurera, producto, rollo...">
        </div>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Costurera</th>
                    <th>Producto a Fabricar</th>
                    <th>Tela (Rollo de Origen)</th>
                    <th>Rollos Entregados</th>
                    <th>Estado</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($asignaciones)): ?>
                    <tr>
                        <td colspan="7" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                            <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"><i class="fa-solid fa-book-open"></i></div>
                            El cuaderno está vacío. Crea tu primera asignación.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($asignaciones as $a): ?>
                        <tr>
                            <td style="color: var(--text-muted); font-weight: 500;">#<?php echo str_pad($a['id_asignacion'], 4, '0', STR_PAD_LEFT); ?></td>
                            <td style="font-weight: 500;">
                                <i class="fa-solid fa-user" style="color: var(--primary); margin-right: 5px;"></i> 
                                <?php echo htmlspecialchars($a['nombre_costurera']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($a['nombre_producto']); ?></td>
                            <td style="color: var(--text-muted); font-size: 0.9rem;">
                                Rollo #<?php echo $a['id_rollo']; ?> (<?php echo htmlspecialchars($a['nombre_tela']); ?>)
                            </td>
                            <td>
                                <span style="background: var(--border); padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 600;">
                                    <?php echo $a['cantidad_asignada']; ?> rollos
                                </span>
                            </td>
                            <td>
                                <?php $estadoLimpio = strtolower($a['estado']); ?>
                                <?php if($estadoLimpio == 'pendiente'): ?>
                                    <span style="background: #FEF3C7; color: #B45309; padding: 0.3rem 0.8rem; border-radius: 20px; font-weight: 600; font-size: 0.85rem;">
                                        <i class="fa-solid fa-clock"></i> Pendiente
                                    </span>
                                <?php elseif($estadoLimpio == 'en proceso'): ?>
                                    <span style="background: #DBEAFE; color: #1E40AF; padding: 0.3rem 0.8rem; border-radius: 20px; font-weight: 600; font-size: 0.85rem;">
                                        <i class="fa-solid fa-spinner"></i> En proceso
                                    </span>
                                <?php else: ?>
                                    <span style="background: #D1FAE5; color: #047857; padding: 0.3rem 0.8rem; border-radius: 20px; font-weight: 600; font-size: 0.85rem;">
                                        <i class="fa-solid fa-check-double"></i> Terminado
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones/editar/" . $a['id_asignacion']; ?>" class="btn-action edit" title="Editar Asignación">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones/eliminar/" . $a['id_asignacion']; ?>" class="btn-action delete" title="Eliminar Asignación" onclick="return confirm('¿Estás seguro de eliminar este registro?');">
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
