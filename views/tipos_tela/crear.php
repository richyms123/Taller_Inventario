<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Registrar Tipo de Tela</h1>
                <p>Añade un nuevo material al catálogo (ej. Mezclilla, Poliéster).</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/tipos_tela/guardar"; ?>" method="POST">
                <div class="form-group">
                    <label>Nombre de la Tela</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-tag" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="text" name="nombre_tela" class="form-control" style="padding-left: 2.5rem;" required pattern=".*\S+.*" title="El nombre no puede estar vacío ni contener solo espacios" placeholder="Ej. Algodón Estampado">
                    </div>
                </div>

                <div class="form-group">
                    <label>¿A qué costurera se le asigna esta tela?</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-gear" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <select name="tipo_maquina" class="form-control" style="padding-left: 2.5rem; appearance: none;" required>
                            <option value="Ambos">Ambos</option>
                            <option value="Overlock">Overlock</option>
                            <option value="Recta">Recta</option>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/tipos_tela"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Material
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
