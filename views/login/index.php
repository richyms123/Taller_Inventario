<div class="center-wrapper">
    <div class="auth-card">
        <div class="icon-large">
            <i class="fa-solid fa-lock"></i>
        </div>
        <h2 style="margin-bottom: 0.5rem;">Acceso Restringido</h2>
        <p style="margin-bottom: 2rem;">Ingresa tus credenciales para continuar</p>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i> Usuario o contraseña incorrectos.
            </div>
        <?php endif; ?>

        <form action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/login/autenticar"; ?>" method="POST">
            <div class="form-group">
                <label>Usuario</label>
                <div style="position: relative;">
                    <i class="fa-solid fa-user" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    <input type="text" name="usuario" class="form-control" style="padding-left: 2.5rem;" placeholder="Ej. admin" required autocomplete="off">
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 2rem;">
                <label>Contraseña</label>
                <div style="position: relative;">
                    <i class="fa-solid fa-key" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    <input type="password" name="password" class="form-control" style="padding-left: 2.5rem;" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Iniciar Sesión
            </button>
        </form>
    </div>
</div>
