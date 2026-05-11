<?php
require_once 'models/Usuario.php';

class LoginController {
    
    // Muestra el formulario de login
    public function index() {
        require_once 'views/layouts/header.php';
        require_once 'views/login/index.php';
        require_once 'views/layouts/footer.php';
    }

    // Procesa la solicitud del formulario
    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            $usuario = new Usuario($db);
            
            $user_input = isset($_POST['usuario']) ? $_POST['usuario'] : '';
            $pass_input = isset($_POST['password']) ? $_POST['password'] : '';

            if ($usuario->login($user_input, $pass_input)) {
                session_start();
                $_SESSION['id_usuario'] = $usuario->id_usuario;
                $_SESSION['nombre_completo'] = $usuario->nombre_completo;
                $_SESSION['usuario'] = $usuario->usuario;
                
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/dashboard");
                exit();
            } else {
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/login/index?error=1");
                exit();
            }
        } else {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/login");
            exit();
        }
    }

    // Cerrar sesión
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario/login");
        exit();
    }
}
?>
