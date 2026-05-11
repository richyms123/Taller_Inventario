<div class="main-content">
    <div class="page-header">
        <div>
            <h1>Catálogo de Personal</h1>
            <p>Gestiona el registro de costureras del taller.</p>
        </div>
        <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/costureras/crear"; ?>" class="btn btn-primary">
            <i class="fa-solid fa-user-plus"></i> Nueva Costurera
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'creado'): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> Costurera registrada exitosamente.
            </div>
        <?php elseif ($_GET['msg'] == 'actualizado'): ?>
            <div class="alert alert-info">
                <i class="fa-solid fa-circle-info"></i> Datos actualizados exitosamente.
            </div>
        <?php elseif ($_GET['msg'] == 'eliminado'): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-user-minus"></i> Costurera dada de baja.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Nombre Completo</th>
                    <th>Teléfono</th>
                    <th>Fecha Ingreso</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($costureras)): ?>
                    <tr>
                        <td colspan="5" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                            <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"><i class="fa-solid fa-users-slash"></i></div>
                            No hay costureras registradas.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($costureras as $c): ?>
                        <tr>
                            <td style="color: var(--text-muted); font-weight: 500;">#<?php echo str_pad($c['id_costurera'], 3, '0', STR_PAD_LEFT); ?></td>
                            <td style="font-weight: 500; font-size: 1.05rem;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 30px; height: 30px; border-radius: 50%; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <?php echo htmlspecialchars($c['nombre_completo']); ?>
                                </div>
                            </td>
                            <td>
                                <span style="color: var(--text-muted);"><i class="fa-solid fa-phone" style="font-size: 0.85rem; margin-right: 5px;"></i> <?php echo htmlspecialchars($c['telefono'] ?? 'N/A'); ?></span>
                            </td>
                            <td>
                                <span style="color: var(--text-muted);"><i class="fa-regular fa-calendar" style="font-size: 0.85rem; margin-right: 5px;"></i> <?php echo date("d/m/Y", strtotime($c['fecha_ingreso'])); ?></span>
                            </td>
                            <td style="text-align: right;">
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/costureras/editar/" . $c['id_costurera']; ?>" class="btn-action edit" title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/costureras/eliminar/" . $c['id_costurera']; ?>" class="btn-action delete" title="Dar de baja" onclick="return confirm('¿Estás seguro de que deseas dar de baja a este personal?');">
                                    <i class="fa-solid fa-user-minus"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
