<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Crear Nuevo Producto</h1>
                <p>Ingresa los detalles del nuevo producto para el catálogo.</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/productos/guardar"; ?>" method="POST">
                <div class="form-group">
                    <label>Nombre del Producto</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-tag" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="text" name="nombre_producto" class="form-control" style="padding-left: 2.5rem;" required pattern=".*\S+.*" title="El nombre no puede estar vacío ni contener solo espacios" placeholder="Ej. Morral Escolar">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Descripción (Opcional)</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-align-left" style="position: absolute; left: 15px; top: 15px; color: var(--text-muted);"></i>
                        <textarea name="descripcion" class="form-control" style="padding-left: 2.5rem;" rows="3" placeholder="Detalles de diseño, color o modelo..."></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label>Precio de Maquila ($)</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-dollar-sign" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="number" step="0.01" min="0.01" name="precio_maquila" class="form-control" style="padding-left: 2.5rem;" required placeholder="Ej. 15.50">
                    </div>
                </div>

                <div class="form-group">
                    <label>¿Quién entrega este producto terminado?</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-gear" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="tipo_maquina" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <option value="Ambos">Ambos</option>
                            <option value="Overlock">Overlock</option>
                            <option value="Recta">Recta</option>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/productos"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
