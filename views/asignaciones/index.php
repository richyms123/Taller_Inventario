<div class="main-content">
    <div class="page-header">
        <div>
            <h1>Asignaciones de Tela</h1>
            <p>El "cuaderno digital": registra qué tela le entregaste a cada costurera.</p>
        </div>
        <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/asignaciones/crear"; ?>" class="btn btn-primary">
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
                <i class="fa-solid fa-shield-halved"></i> Error: Esta asignación tiene dependencias y no se puede borrar.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
        <div style="position: relative; width: 100%; max-width: 350px;">
            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
            <input type="text" id="searchInput" class="form-control" style="padding-left: 2.5rem; border-radius: 20px; background: #fff;" placeholder="Buscar costurera o rollo...">
        </div>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Fecha</th>
                    <th>Costurera</th>
                    <th>Tela (Rollo de Origen)</th>
                    <th>Rollos Entregados</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($asignaciones)): ?>
                    <tr>
                        <td colspan="6" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                            <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"><i class="fa-solid fa-book-open"></i></div>
                            El cuaderno está vacío. Crea tu primera asignación.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($asignaciones as $a): ?>
                        <tr>
                            <td style="color: var(--text-muted); font-weight: 500;">#<?php echo str_pad($a['id_asignacion'], 4, '0', STR_PAD_LEFT); ?></td>
                            <td>
                                <span style="color: var(--text-muted);"><i class="fa-regular fa-calendar"></i> <?php echo date("d/m/Y", strtotime($a['fecha_asignacion'])); ?></span>
                            </td>
                            <td style="font-weight: 500;">
                                <i class="fa-solid fa-user" style="color: var(--primary); margin-right: 5px;"></i> 
                                <?php echo htmlspecialchars($a['nombre_costurera']); ?>
                            </td>
                            <td style="color: var(--text-muted); font-size: 0.9rem;">
                                Rollo #<?php echo $a['id_rollo']; ?> (<?php echo htmlspecialchars($a['nombre_tela']); ?>)
                            </td>
                            <td>
                                <span style="background: var(--border); padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 600;">
                                    <?php echo $a['rollos_utilizados']; ?> rollos
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
