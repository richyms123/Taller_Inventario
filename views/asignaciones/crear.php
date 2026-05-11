<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Nueva Asignación de Trabajo</h1>
                <p>Registra qué vas a fabricar, quién lo hará y qué tela usará.</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones/guardar"; ?>" method="POST">
                <div class="form-group">
                    <label>¿A quién se le asigna?</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-user" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_costurera" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <option value="">-- Selecciona a la costurera --</option>
                            <?php foreach($costureras as $c): ?>
                                <option value="<?php echo $c['id_costurera']; ?>"><?php echo htmlspecialchars($c['nombre_completo']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>¿Qué va a fabricar?</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-bag-shopping" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_producto" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <option value="">-- Selecciona el producto --</option>
                            <?php foreach($productos as $p): ?>
                                <option value="<?php echo $p['id_producto']; ?>"><?php echo htmlspecialchars($p['nombre_producto']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>¿De qué rollo/corte se tomó la tela?</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-boxes-stacked" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_rollo" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <option value="">-- Selecciona el rollo origen --</option>
                            <?php foreach($rollos as $r): ?>
                                <option value="<?php echo $r['id_rollo']; ?>">Rollo #<?php echo str_pad($r['id_rollo'], 3, '0', STR_PAD_LEFT); ?> (<?php echo htmlspecialchars($r['nombre_tela']); ?> - <?php echo $r['metros_disponibles']; ?> disponibles)</option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Cantidad de Rollos a Entregar</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-arrow-up-9-1" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="number" name="cantidad_asignada" class="form-control" style="padding-left: 2.5rem;" required placeholder="Ej. 2">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha de Asignación</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-calendar-day" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="date" name="fecha_asignacion" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
