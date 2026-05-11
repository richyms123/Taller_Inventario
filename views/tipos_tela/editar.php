<div class="main-content">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 2rem;">
            <div>
                <h1>Editar Tela</h1>
                <p>Corrige el nombre del material seleccionado.</p>
            </div>
        </div>

        <div class="card">
            <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/tipos_tela/actualizar/" . $this->tipoTela->id_tipo_tela; ?>" method="POST">
                <div class="form-group">
                    <label>Nombre de la Tela</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-tag" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="text" name="nombre_tela" class="form-control" style="padding-left: 2.5rem;" required value="<?php echo htmlspecialchars($this->tipoTela->nombre_tela); ?>">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/tipos_tela"; ?>" class="btn" style="background: var(--border); color: var(--text-main); width: 100%;">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Actualizar Material
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
