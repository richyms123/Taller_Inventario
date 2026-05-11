<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller Inventario</title>
    <!-- Cargar Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Cargar FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Cargar CSS principal -->
    <link rel="stylesheet" href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/public/css/style.css?v=" . time(); ?>">
</head>
<body>
    <?php 
    // Si la sesión está iniciada, mostramos el navbar
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if(isset($_SESSION['id_usuario'])): 
        $baseUrl = "http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario";
    ?>
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="<?php echo $baseUrl; ?>/" class="navbar-brand">
                <div class="brand-icon"><i class="fa-solid fa-layer-group"></i></div>
                TallerApp
            </a>
        </div>
        
        <div class="nav-menu">
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin: 10px 0 5px 15px;">General</div>
            <a href="<?php echo $baseUrl; ?>/dashboard" class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/Taller_Inventario/dashboard' || $_SERVER['REQUEST_URI'] == '/Taller_Inventario/dashboard/') ? 'active' : ''; ?>">
                <i class="fa-solid fa-chart-pie" style="width: 20px;"></i> Dashboard
            </a>
            
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin: 20px 0 5px 15px;">Catálogos</div>
            <a href="<?php echo $baseUrl; ?>/productos" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/productos') !== false ? 'active' : ''; ?>">
                <i class="fa-solid fa-tags" style="width: 20px;"></i> Productos
            </a>
            <a href="<?php echo $baseUrl; ?>/costureras" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/costureras') !== false ? 'active' : ''; ?>">
                <i class="fa-solid fa-users-gear" style="width: 20px;"></i> Costureras
            </a>
            <a href="<?php echo $baseUrl; ?>/tipos_tela" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/tipos_tela') !== false ? 'active' : ''; ?>">
                <i class="fa-solid fa-swatchbook" style="width: 20px;"></i> Tipos de Tela
            </a>

            <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin: 20px 0 5px 15px;">Producción</div>
            <a href="<?php echo $baseUrl; ?>/rollos_tela" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/rollos_tela') !== false ? 'active' : ''; ?>">
                <i class="fa-solid fa-boxes-stacked" style="width: 20px;"></i> Almacén de Tela
            </a>
            <a href="<?php echo $baseUrl; ?>/asignaciones" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/asignaciones') !== false ? 'active' : ''; ?>">
                <i class="fa-solid fa-clipboard-list" style="width: 20px;"></i> Asignaciones
            </a>
            <a href="<?php echo $baseUrl; ?>/entregas" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/entregas') !== false ? 'active' : ''; ?>">
                <i class="fa-solid fa-truck-ramp-box" style="width: 20px;"></i> Entregas
            </a>
            
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin: 20px 0 5px 15px;">Métricas</div>
            <a href="<?php echo $baseUrl; ?>/reportes" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/reportes') !== false ? 'active' : ''; ?>">
                <i class="fa-solid fa-chart-line" style="width: 20px;"></i> Reporte Diario
            </a>
        </div>

        <div class="sidebar-footer">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div class="user-avatar" style="width: 32px; height: 32px;"><i class="fa-solid fa-user" style="font-size: 0.8rem;"></i></div>
                <div class="user-name" style="font-size: 0.85rem; max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo htmlspecialchars($_SESSION['nombre_completo']); ?>">
                    <?php echo htmlspecialchars($_SESSION['nombre_completo']); ?>
                </div>
            </div>
            <a href="<?php echo $baseUrl; ?>/login/logout" class="btn-action delete" title="Cerrar Sesión">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        </div>
    </aside>
    <?php endif; ?>
