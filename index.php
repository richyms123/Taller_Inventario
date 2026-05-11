<?php
// Configurar zona horaria para coincidir con la base de datos
date_default_timezone_set('America/Mexico_City');

// Cargar la configuración de la base de datos
require_once 'config/database.php';

// Obtener la URL, limpiarla y separarla en partes
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home/index';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// 1. Definir el Controlador
// Capitalizamos la primera letra y convertimos guiones/guiones bajos a CamelCase (ej. 'tipos_tela' -> 'TiposTelaController')
$controllerBase = isset($url[0]) && $url[0] != '' ? str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $url[0]))) : 'Home';
$controllerName = $controllerBase . 'Controller';
$controllerFile = 'controllers/' . $controllerName . '.php';

// 2. Definir el Método
$methodName = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// 3. Obtener los Parámetros (todo lo que venga después del método)
$params = array_slice($url, 2);

// 4. Lógica de Enrutamiento
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Instanciar el controlador
    $controller = new $controllerName();
    
    // Comprobar si el método existe en el controlador
    if (method_exists($controller, $methodName)) {
        // Llamar al método con sus parámetros
        call_user_func_array([$controller, $methodName], $params);
    } else {
        // Podrías cargar un controlador de Errores o una vista 404
        echo "<h1>Error 404</h1>";
        echo "<p>El método '{$methodName}' no existe en '{$controllerName}'.</p>";
    }
} else {
    // Si el archivo del controlador no existe
    echo "<h1>Error 404</h1>";
    echo "<p>El controlador '{$controllerName}' no fue encontrado.</p>";
}
?>
