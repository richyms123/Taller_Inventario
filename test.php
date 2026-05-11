<?php
require 'config/database.php';
$db = (new Database())->getConnection();

// Primero ver que hay
$stmt = $db->query('DESCRIBE rollos_tela');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

// Modificar la tabla
try {
    $db->exec("ALTER TABLE rollos_tela CHANGE metros_iniciales cantidad_inicial INT NOT NULL DEFAULT 1");
    $db->exec("ALTER TABLE rollos_tela CHANGE metros_disponibles rollos_disponibles INT NOT NULL DEFAULT 1");
    $db->exec("ALTER TABLE rollos_tela ADD COLUMN codigo_lote VARCHAR(50) DEFAULT NULL AFTER id_tipo_tela");
    echo "Modificacion exitosa\n";
} catch(Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
