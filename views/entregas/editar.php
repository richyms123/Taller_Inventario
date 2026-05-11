<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Editar Registro de Entrega</h1>
                <p>Corrige errores en la contabilización de piezas.</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas/actualizar/" . $this->entrega->id_entrega; ?>" method="POST">
                <div class="form-group">
                    <label>Trabajo (Asignación) Asociado</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-clipboard-check" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_asignacion" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <?php foreach($asignaciones as $a): ?>
                                <option value="<?php echo $a['id_asignacion']; ?>" <?php echo ($a['id_asignacion'] == $this->entrega->id_asignacion) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($a['nombre_costurera']); ?> - <?php echo htmlspecialchars($a['nombre_producto']); ?> (Asignación #<?php echo str_pad($a['id_asignacion'], 3, '0', STR_PAD_LEFT); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha y Hora de Entrega</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-clock" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="datetime-local" name="fecha_entrega" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo date('Y-m-d\TH:i', strtotime($this->entrega->fecha_entrega)); ?>">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Piezas Buenas</label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-check" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                            <input type="number" name="piezas_buenas" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo htmlspecialchars($this->entrega->cantidad_buenas); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Piezas Malas / Defectuosas</label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-xmark" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                            <input type="number" name="piezas_malas" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo htmlspecialchars($this->entrega->cantidad_defectuosas); ?>">
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
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
