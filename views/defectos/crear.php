<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Registrar Mermas / Defectos</h1>
                <p>Anota los productos que salieron mal para descontarlos del total global.</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/defectos/guardar"; ?>" method="POST">
                
                <div class="form-group">
                    <label>¿Qué producto salió defectuoso?</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-box" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_producto" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <option value="">-- Selecciona el producto --</option>
                            <?php foreach($productos as $p): ?>
                                <?php if($p['activo'] == 1): ?>
                                    <option value="<?php echo $p['id_producto']; ?>"><?php echo htmlspecialchars($p['nombre_producto']); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Cantidad de Defectos</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-xmark" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="number" name="cantidad" class="form-control" style="padding-left: 2.5rem;" required min="1" placeholder="Ej. 5">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha de Registro</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-calendar-day" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="date" name="fecha_registro" class="form-control" style="padding-left: 2.5rem; background-color: var(--bg-main); color: var(--text-muted); cursor: not-allowed;" required readonly value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <small style="color: var(--text-muted); display: block; margin-top: 5px;">La fecha se asigna automáticamente al día de hoy.</small>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/entregas"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="background: #EF4444; border-color: #EF4444; width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Defectos
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
