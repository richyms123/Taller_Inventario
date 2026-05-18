<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Editar Costurera</h1>
                <p>Modifica los datos personales de la costurera.</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/costureras/actualizar/" . $this->costurera->id_costurera; ?>" method="POST">
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-user" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="text" name="nombre_completo" class="form-control" style="padding-left: 2.5rem;" required pattern=".*\S+.*" title="El nombre no puede estar vacío ni contener solo espacios" value="<?php echo htmlspecialchars($this->costurera->nombre_completo); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Teléfono</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-phone" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="tel" name="telefono" class="form-control" style="padding-left: 2.5rem;" pattern="\d{10}" maxlength="10" title="Debe contener exactamente 10 números, sin letras ni espacios" value="<?php echo htmlspecialchars($this->costurera->telefono); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha de Ingreso</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-calendar-day" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="date" name="fecha_ingreso" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo htmlspecialchars($this->costurera->fecha_ingreso); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Tipo de Máquina</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-gear" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="tipo_maquina" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <option value="Overlock" <?php echo ($this->costurera->tipo_maquina == 'Overlock') ? 'selected' : ''; ?>>Overlock</option>
                            <option value="Recta" <?php echo ($this->costurera->tipo_maquina == 'Recta') ? 'selected' : ''; ?>>Recta</option>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/costureras"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Actualizar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
