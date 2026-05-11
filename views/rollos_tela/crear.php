<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Ingresar Nuevo Rollo</h1>
                <p>Registra la entrada de un rollo de tela al almacén.</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/rollos_tela/guardar"; ?>" method="POST">
                <div class="form-group">
                    <label>Tipo de Tela</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-layer-group" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_tipo_tela" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <option value="">-- Selecciona el tipo de tela --</option>
                            <?php foreach($telas as $t): ?>
                                <option value="<?php echo $t['id_tipo_tela']; ?>"><?php echo htmlspecialchars($t['nombre_tela']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Cantidad de Rollos (Lote Inicial)</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-boxes-stacked" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="number" name="cantidad_inicial" class="form-control" style="padding-left: 2.5rem;" required min="1" step="1" placeholder="Ej. 50">
                    </div>
                    <small style="color: var(--text-muted); display: block; margin-top: 5px;">La cantidad de rollos disponibles se igualará a esta cantidad inicial.</small>
                </div>

                <div class="form-group">
                    <label>Fecha de Entrada</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-calendar-day" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="date" name="fecha_ingreso" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/rollos_tela"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Registrar Rollo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
