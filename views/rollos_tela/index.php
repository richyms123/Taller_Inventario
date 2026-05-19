<div class="main-content">
    <div class="page-header">
        <div>
            <h1>Inventario de Telas</h1>
            <p>Registra y consulta los rollos de tela físicos en el almacén.</p>
        </div>
        <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/rollos_tela/crear"; ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Registrar Rollo
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'creado'): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> Rollo registrado en el inventario.
            </div>
        <?php elseif ($_GET['msg'] == 'actualizado'): ?>
            <div class="alert alert-info">
                <i class="fa-solid fa-circle-info"></i> Rollo actualizado exitosamente.
            </div>
        <?php elseif ($_GET['msg'] == 'eliminado'): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-trash-can"></i> Rollo eliminado del inventario.
            </div>
        <?php elseif ($_GET['msg'] == 'error_en_uso'): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-shield-halved"></i> Error: Este rollo ya ha sido asignado a trabajos, no puede eliminarse.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Lote</th>
                    <th>Tipo de Tela</th>
                    <th>Rollos Iniciales</th>
                    <th>Rollos Disponibles</th>
                    <th>Fecha de Entrada</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rollos)): ?>
                    <tr>
                        <td colspan="6" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                            <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"><i class="fa-solid fa-boxes-stacked"></i></div>
                            El almacén está vacío. No hay rollos registrados.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($rollos as $r): ?>
                        <tr>
                            <td><strong>#<?php echo str_pad($r['id_rollo'], 3, '0', STR_PAD_LEFT); ?></strong></td>
                            <td style="font-weight: 500;">
                                <i class="fa-solid fa-layer-group" style="color: var(--primary); margin-right: 5px;"></i> 
                                <?php echo htmlspecialchars($r['nombre_tela']); ?>
                            </td>
                            <td><?php echo $r['cantidad_inicial']; ?> rollos</td>
                            <td>
                                <?php 
                                    $porcentaje = ($r['cantidad_inicial'] > 0) ? ($r['rollos_disponibles'] / $r['cantidad_inicial']) * 100 : 0;
                                    $color = '#10B981';
                                    if($porcentaje <= 20) $color = '#EF4444';
                                    elseif($porcentaje <= 50) $color = '#F59E0B';
                                ?>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="font-weight: 600; color: <?php echo $color; ?>; min-width: 60px;">
                                        <?php echo $r['rollos_disponibles']; ?> rollos
                                    </span>
                                    <div style="flex-grow: 1; height: 6px; background: var(--border); border-radius: 3px; overflow: hidden; width: 60px;">
                                        <div style="width: <?php echo $porcentaje; ?>%; height: 100%; background: <?php echo $color; ?>;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo date("d/m/Y", strtotime($r['fecha_ingreso'])); ?></td>
                            <td style="text-align: right;">
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/rollos_tela/editar/" . $r['id_rollo']; ?>" class="btn-action edit" title="Ajustar Inventario">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/rollos_tela/eliminar/" . $r['id_rollo']; ?>" class="btn-action delete" title="Eliminar Rollo" onclick="return confirm('¿Estás seguro de eliminar este rollo del inventario?');">
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
