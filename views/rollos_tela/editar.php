<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Ajustar Rollo</h1>
                <p>Edita los detalles o corrige el metraje de este rollo.</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/rollos_tela/actualizar/" . $this->rolloTela->id_rollo; ?>" method="POST">
                <div class="form-group">
                    <label>Tipo de Tela</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-layer-group" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_tipo_tela" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <?php foreach($telas as $t): ?>
                                <option value="<?php echo $t['id_tipo_tela']; ?>" <?php echo ($t['id_tipo_tela'] == $this->rolloTela->id_tipo_tela) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($t['nombre_tela']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Cantidad Inicial de Rollos</label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-boxes-stacked" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                            <input type="number" name="cantidad_inicial" class="form-control" style="padding-left: 2.5rem;" required min="1" step="1" value="<?php echo htmlspecialchars($this->rolloTela->cantidad_inicial); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Rollos Disponibles Actualmente</label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-check-to-slot" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                            <input type="number" name="rollos_disponibles" class="form-control" style="padding-left: 2.5rem;" required min="0" step="1" value="<?php echo htmlspecialchars($this->rolloTela->rollos_disponibles); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha de Entrada</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-calendar-day" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="date" name="fecha_ingreso" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo htmlspecialchars($this->rolloTela->fecha_ingreso); ?>">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/rollos_tela"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
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
