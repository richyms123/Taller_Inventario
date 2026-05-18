<?php
class HomeController {
    public function index() {
        session_start();
        if (isset($_SESSION['id_usuario'])) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Taller_Inventario-main/dashboard");
            exit();
        }

        require_once 'views/layouts/header.php';
        require_once 'views/home/index.php';
        require_once 'views/layouts/footer.php';
    }
}
?>
