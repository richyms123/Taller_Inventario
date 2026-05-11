<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Registrar Costurera</h1>
                <p>Ingresa los detalles del nuevo personal.</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/costureras/guardar"; ?>" method="POST">
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-user" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="text" name="nombre_completo" class="form-control" style="padding-left: 2.5rem;" required placeholder="Ej. María López">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Teléfono (Opcional)</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-phone" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="text" name="telefono" class="form-control" style="padding-left: 2.5rem;" placeholder="Ej. 555-1234">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha de Ingreso</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-calendar-day" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="date" name="fecha_ingreso" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/costureras"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
