<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Editar Asignación</h1>
                <p>Modifica los detalles del trabajo asignado.</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones/actualizar/" . $this->asignacion->id_asignacion; ?>" method="POST">
                <div class="form-group">
                    <label>Costurera</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-user" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_costurera" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <?php foreach($costureras as $c): ?>
                                <option value="<?php echo $c['id_costurera']; ?>" <?php echo ($c['id_costurera'] == $this->asignacion->id_costurera) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($c['nombre_completo']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Producto a fabricar</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-bag-shopping" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_producto" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <?php foreach($productos as $p): ?>
                                <option value="<?php echo $p['id_producto']; ?>" <?php echo ($p['id_producto'] == $this->asignacion->id_producto) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($p['nombre_producto']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Rollo de origen</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-boxes-stacked" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_rollo" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <?php foreach($rollos as $r): ?>
                                <option value="<?php echo $r['id_rollo']; ?>" <?php echo ($r['id_rollo'] == $this->asignacion->id_rollo) ? 'selected' : ''; ?>>
                                    Rollo #<?php echo str_pad($r['id_rollo'], 3, '0', STR_PAD_LEFT); ?> (<?php echo htmlspecialchars($r['nombre_tela']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Rollos Entregados</label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-arrow-up-9-1" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                            <input type="number" name="cantidad_asignada" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo htmlspecialchars($this->asignacion->cantidad_asignada); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Estado</label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-flag" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                            <select name="estado" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                                <option value="Pendiente" <?php echo (strtolower($this->asignacion->estado) == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="En proceso" <?php echo (strtolower($this->asignacion->estado) == 'en proceso') ? 'selected' : ''; ?>>En proceso</option>
                                <option value="Terminado" <?php echo (strtolower($this->asignacion->estado) == 'terminado') ? 'selected' : ''; ?>>Terminado</option>
                            </select>
                            <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha de Asignación</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-calendar-day" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="date" name="fecha_asignacion" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo date('Y-m-d', strtotime($this->asignacion->fecha_asignacion)); ?>">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
