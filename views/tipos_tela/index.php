<div class="main-content">
    <div class="page-header">
        <div>
            <h1>Catálogo de Telas</h1>
            <p>Gestiona los tipos de tela (materia prima) del taller.</p>
        </div>
        <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/tipos_tela/crear"; ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nuevo Tipo
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'creado'): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> Tipo de tela registrado exitosamente.
            </div>
        <?php elseif ($_GET['msg'] == 'actualizado'): ?>
            <div class="alert alert-info">
                <i class="fa-solid fa-circle-info"></i> Nombre actualizado exitosamente.
            </div>
        <?php elseif ($_GET['msg'] == 'eliminado'): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-trash-can"></i> Tela eliminada del catálogo.
            </div>
        <?php elseif ($_GET['msg'] == 'error_duplicado'): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i> Error: Ya existe una tela registrada con ese nombre.
            </div>
        <?php elseif ($_GET['msg'] == 'error_en_uso'): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-shield-halved"></i> Error: No se puede eliminar esta tela porque ya hay rollos de tela o asignaciones vinculadas a ella.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Nombre del Material</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($telas)): ?>
                    <tr>
                        <td colspan="3" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                            <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"><i class="fa-solid fa-scroll"></i></div>
                            No hay tipos de tela registrados.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($telas as $t): ?>
                        <tr>
                            <td style="color: var(--text-muted); font-weight: 500;">#<?php echo str_pad($t['id_tipo_tela'], 3, '0', STR_PAD_LEFT); ?></td>
                            <td style="font-weight: 500; font-size: 1.05rem;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 30px; height: 30px; border-radius: 8px; background: #FEF3C7; color: var(--warning); display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                                        <i class="fa-solid fa-layer-group"></i>
                                    </div>
                                    <?php echo htmlspecialchars($t['nombre_tela']); ?>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/tipos_tela/editar/" . $t['id_tipo_tela']; ?>" class="btn-action edit" title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/tipos_tela/eliminar/" . $t['id_tipo_tela']; ?>" class="btn-action delete" title="Eliminar definitivamente" onclick="return confirm('¿Estás seguro de que deseas eliminar este tipo de tela?');">
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
