<div class="main-content">
    <div class="page-header">
        <div>
            <h1>Catálogo de Productos</h1>
            <p>Gestiona los morrales, chalecos y otros productos.</p>
        </div>
        <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/productos/crear"; ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nuevo Producto
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'creado'): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> Producto creado exitosamente.
            </div>
        <?php elseif ($_GET['msg'] == 'actualizado'): ?>
            <div class="alert alert-info">
                <i class="fa-solid fa-circle-info"></i> Producto actualizado exitosamente.
            </div>
        <?php elseif ($_GET['msg'] == 'eliminado'): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-trash-can"></i> Producto eliminado del catálogo.
            </div>
        <?php elseif ($_GET['msg'] == 'error_duplicado'): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i> Error: Ya existe un producto con ese nombre.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Nombre del Producto</th>
                    <th>Precio Maquila</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($productos)): ?>
                    <tr>
                        <td colspan="4" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                            <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"><i class="fa-solid fa-box-open"></i></div>
                            No hay productos registrados en el catálogo.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($productos as $p): ?>
                        <tr>
                            <td style="color: var(--text-muted); font-weight: 500;">#<?php echo str_pad($p['id_producto'], 3, '0', STR_PAD_LEFT); ?></td>
                            <td style="font-weight: 500; font-size: 1.05rem;">
                                <?php echo htmlspecialchars($p['nombre_producto']); ?>
                                <?php if(!empty($p['descripcion'])): ?>
                                    <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 400; margin-top: 4px;">
                                        <?php echo htmlspecialchars($p['descripcion']); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span style="background: #D1FAE5; color: #047857; padding: 0.3rem 0.8rem; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                                    $<?php echo number_format($p['precio_maquila'], 2); ?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/productos/editar/" . $p['id_producto']; ?>" class="btn-action edit" title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/productos/eliminar/" . $p['id_producto']; ?>" class="btn-action delete" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
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
