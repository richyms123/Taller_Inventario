<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Nueva Asignación de Tela</h1>
                <p>Registra a quién se le entrega tela y de qué rollo.</p>
            </div>
        </div>

        <div class="card">
            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'stock_insuficiente'): ?>
                <div class="alert alert-error" style="margin-bottom: 1.5rem; background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; padding: 10px; border-radius: 8px;">
                    <i class="fa-solid fa-triangle-exclamation"></i> <strong>Error:</strong> Stock insuficiente de rollos para el tipo de tela seleccionado.
                </div>
            <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'error'): ?>
                <div class="alert alert-error" style="margin-bottom: 1.5rem; background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; padding: 10px; border-radius: 8px;">
                    <i class="fa-solid fa-triangle-exclamation"></i> <strong>Error:</strong> Ocurrió un problema al procesar la asignación. Inténtalo de nuevo.
                </div>
            <?php endif; ?>

            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/asignaciones/guardar"; ?>" method="POST">
                <div class="form-group">
                    <label>¿A quién se le asigna?</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-user" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_costurera" id="id_costurera" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <option value="" data-maquina="">-- Selecciona a la costurera --</option>
                            <?php foreach($costureras as $c): ?>
                                <option value="<?php echo $c['id_costurera']; ?>" data-maquina="<?php echo htmlspecialchars($c['tipo_maquina'] ?? 'Overlock'); ?>">
                                    <?php echo htmlspecialchars($c['nombre_completo']); ?> (<?php echo htmlspecialchars($c['tipo_maquina'] ?? 'Overlock'); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>¿Qué tipo de tela se va a entregar?</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-layer-group" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_tipo_tela" id="id_tipo_tela" class="form-control" style="padding-left: 2.5rem; appearance: none;" required disabled>
                            <option value="" data-maquina="Ambos">-- Selecciona primero la costurera --</option>
                            <?php foreach($tipos_tela as $t): ?>
                                <option value="<?php echo $t['id_tipo_tela']; ?>" data-maquina="<?php echo htmlspecialchars($t['tipo_maquina'] ?? 'Ambos'); ?>">
                                    <?php echo htmlspecialchars($t['nombre_tela']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                    <small style="color: var(--text-muted); display: block; margin-top: 5px;">El sistema tomará automáticamente los rollos más antiguos del inventario.</small>
                </div>

                <div class="form-group">
                    <label>Cantidad de Rollos Entregados</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-arrow-up-9-1" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="number" name="rollos_utilizados" class="form-control" style="padding-left: 2.5rem;" required min="1" placeholder="Ej. 2">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha de Asignación</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-calendar-day" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="date" name="fecha_asignacion" class="form-control" style="padding-left: 2.5rem; background-color: var(--bg-main); color: var(--text-muted); cursor: not-allowed;" required readonly value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <small style="color: var(--text-muted); display: block; margin-top: 5px;">La fecha se asigna automáticamente al momento actual.</small>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const costureraSelect = document.getElementById('id_costurera');
    const tipoTelaSelect = document.getElementById('id_tipo_tela');
    const defaultOption = tipoTelaSelect.querySelector('option[value=""]');
    
    // Store original options
    const allTelas = Array.from(tipoTelaSelect.options).slice(1);

    costureraSelect.addEventListener('change', function() {
        const selectedCosturera = this.options[this.selectedIndex];
        const maquinaCosturera = selectedCosturera.getAttribute('data-maquina');

        // Clear and disable if no costurera
        if (!this.value) {
            tipoTelaSelect.innerHTML = '';
            defaultOption.text = '-- Selecciona primero la costurera --';
            tipoTelaSelect.appendChild(defaultOption);
            tipoTelaSelect.disabled = true;
            return;
        }

        tipoTelaSelect.disabled = false;
        tipoTelaSelect.innerHTML = '';
        defaultOption.text = '-- Selecciona el tipo de tela --';
        tipoTelaSelect.appendChild(defaultOption);

        // Filter telas
        allTelas.forEach(option => {
            const maquinaTela = option.getAttribute('data-maquina');
            if (maquinaTela === 'Ambos' || maquinaTela === maquinaCosturera) {
                tipoTelaSelect.appendChild(option.cloneNode(true));
            }
        });
    });
});
</script>
