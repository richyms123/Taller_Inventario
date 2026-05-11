<div class="main-content">
    <div class="page-header">
        <div>
            <h1>Dashboard</h1>
            <p>Resumen general de tu taller de costura</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
        <div class="card card-hover">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1rem;">
                <div style="background: var(--primary-soft); color: var(--primary); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 style="margin: 0; font-size: 1.3rem;">Rollos Disponibles</h3>
            </div>
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--primary);"><?php echo $totalRollos; ?></div>
            <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">Rollos actualmente en el almacén</p>
        </div>
        
        <div class="card card-hover">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1rem;">
                <div style="background: #FEF3C7; color: var(--warning); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <h3 style="margin: 0; font-size: 1.3rem;">Trabajos Activos</h3>
            </div>
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--warning);"><?php echo $asignacionesActivas; ?></div>
            <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">Asignaciones pendientes o en proceso</p>
        </div>

        <div class="card card-hover">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1rem;">
                <div style="background: #D1FAE5; color: var(--secondary); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    <i class="fa-solid fa-check-double"></i>
                </div>
                <h3 style="margin: 0; font-size: 1.3rem;">Producción de Hoy</h3>
            </div>
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--secondary);"><?php echo $piezasHoy; ?></div>
            <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">Piezas buenas entregadas el día de hoy</p>
        </div>
    </div>
</div>
