<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Editar Producto</h1>
                <p>Modifica los detalles del producto seleccionado.</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/productos/actualizar/" . $this->producto->id_producto; ?>" method="POST">
                <div class="form-group">
                    <label>Nombre del Producto</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-tag" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="text" name="nombre_producto" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo htmlspecialchars($this->producto->nombre_producto); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Descripción</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-align-left" style="position: absolute; left: 15px; top: 15px; color: var(--text-muted);"></i>
                        <textarea name="descripcion" class="form-control" style="padding-left: 2.5rem;" rows="3"><?php echo htmlspecialchars($this->producto->descripcion); ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label>Precio de Maquila ($)</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-dollar-sign" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="number" step="0.01" name="precio_maquila" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo htmlspecialchars($this->producto->precio_maquila); ?>">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/productos"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Actualizar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
