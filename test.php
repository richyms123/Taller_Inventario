<?php require 'config/database.php'; $db = (new Database())->getConnection(); $stmt = $db->query('SELECT * FROM productos'); print_r($stmt->fetchAll(PDO::FETCH_ASSOC)); ?>
