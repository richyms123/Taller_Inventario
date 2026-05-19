<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Registrar Entrega de Producción</h1>
                <p>Anota las piezas que una costurera acaba de terminar.</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas/guardar"; ?>" method="POST">
                
                <div class="form-group" style="margin-bottom: 1.5rem; background: #FEF2F2; padding: 10px 15px; border-radius: 8px; border: 1px solid #FECACA;">
                    <label style="display: flex; align-items: center; gap: 10px; margin: 0; cursor: pointer; color: #DC2626; font-weight: 600;">
                        <input type="checkbox" name="es_arreglo" id="es_arreglo" value="1" style="width: 20px; height: 20px;">
                        Es un producto arreglado (Merma recuperada)
                    </label>
                </div>

                <div class="form-group" id="grupo_costurera">
                    <label>¿Quién realiza la entrega?</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-user-check" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_costurera" id="id_costurera" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <option value="" data-maquina="">-- Selecciona la costurera --</option>
                            <?php foreach($costureras as $c): ?>
                                <?php if($c['activo'] == 1): ?>
                                    <option value="<?php echo $c['id_costurera']; ?>" data-maquina="<?php echo htmlspecialchars($c['tipo_maquina'] ?? 'Overlock'); ?>">
                                        <?php echo htmlspecialchars($c['nombre_completo']); ?> (<?php echo htmlspecialchars($c['tipo_maquina'] ?? 'Overlock'); ?>)
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>¿Qué producto está entregando?</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-box" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="id_producto" id="id_producto" class="form-control" style="padding-left: 2.5rem; appearance: none;" required disabled>
                            <option value="" data-maquina="Ambos">-- Selecciona primero la costurera --</option>
                            <?php foreach($productos as $p): ?>
                                <?php if($p['activo'] == 1): ?>
                                    <option value="<?php echo $p['id_producto']; ?>" data-maquina="<?php echo htmlspecialchars($p['tipo_maquina'] ?? 'Ambos'); ?>">
                                        <?php echo htmlspecialchars($p['nombre_producto']); ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha y Hora de Entrega</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-clock" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="datetime-local" name="fecha_entrega" class="form-control" style="padding-left: 2.5rem; background-color: var(--bg-main); color: var(--text-muted); cursor: not-allowed;" required readonly value="<?php echo date('Y-m-d\TH:i'); ?>">
                    </div>
                    <small style="color: var(--text-muted); display: block; margin-top: 5px;">La fecha se asigna automáticamente al momento actual.</small>
                </div>

                <div class="form-group">
                    <label>Piezas Entregadas (Buenas)</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-check" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="number" name="piezas_buenas" class="form-control" style="padding-left: 2.5rem;" required min="1" step="1" pattern="^[1-9]\d*$" placeholder="Ej. 20">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/entregas"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Entrega
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkArreglo = document.getElementById('es_arreglo');
    const selectCosturera = document.getElementById('id_costurera');
    const grupoCosturera = document.getElementById('grupo_costurera');
    const selectProducto = document.getElementById('id_producto');
    
    const defaultProductoOption = selectProducto.querySelector('option[value=""]');
    const allProductos = Array.from(selectProducto.options).slice(1);

    function triggerFiltrado() {
        if (checkArreglo.checked) {
            // If it's an arreglo, costurera is not required, so we can't filter by costurera's machine.
            // We should show ALL products.
            selectProducto.disabled = false;
            selectProducto.innerHTML = '';
            defaultProductoOption.text = '-- Selecciona el producto --';
            selectProducto.appendChild(defaultProductoOption);
            allProductos.forEach(option => selectProducto.appendChild(option.cloneNode(true)));
            return;
        }

        const selectedCosturera = selectCosturera.options[selectCosturera.selectedIndex];
        const maquinaCosturera = selectedCosturera ? selectedCosturera.getAttribute('data-maquina') : null;

        if (!selectCosturera.value) {
            selectProducto.innerHTML = '';
            defaultProductoOption.text = '-- Selecciona primero la costurera --';
            selectProducto.appendChild(defaultProductoOption);
            selectProducto.disabled = true;
            return;
        }

        selectProducto.disabled = false;
        selectProducto.innerHTML = '';
        defaultProductoOption.text = '-- Selecciona el producto --';
        selectProducto.appendChild(defaultProductoOption);

        allProductos.forEach(option => {
            const maquinaProducto = option.getAttribute('data-maquina');
            if (maquinaProducto === 'Ambos' || maquinaProducto === maquinaCosturera) {
                selectProducto.appendChild(option.cloneNode(true));
            }
        });
    }

    checkArreglo.addEventListener('change', function() {
        if (this.checked) {
            selectCosturera.removeAttribute('required');
            selectCosturera.value = '';
            selectCosturera.disabled = true;
            grupoCosturera.style.opacity = '0.5';
        } else {
            selectCosturera.setAttribute('required', 'required');
            selectCosturera.disabled = false;
            grupoCosturera.style.opacity = '1';
        }
        triggerFiltrado();
    });

    selectCosturera.addEventListener('change', triggerFiltrado);
    
    // Check initial state
    if (checkArreglo.checked || selectCosturera.value) {
        triggerFiltrado();
    }
});
</script>
