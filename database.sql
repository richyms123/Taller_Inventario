-- 1. Crear la base de datos
CREATE DATABASE IF NOT EXISTS taller_inventario;
USE taller_inventario;

-- 2. Tabla de Administradores (El patrón y hermanas)
CREATE TABLE usuarios_admin (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    activo TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Catálogo de Productos (Morrales, chalecos, etc.)
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    precio_maquila DECIMAL(10, 2) NOT NULL,
    tipo_maquina VARCHAR(20) DEFAULT 'Ambos',
    activo TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Catálogo de Personal (Costureras)
CREATE TABLE costureras (
    id_costurera INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    fecha_ingreso DATE NOT NULL,
    tipo_maquina VARCHAR(20) DEFAULT 'Overlock',
    activo TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. NUEVA: Catálogo de Tipos de Tela (Evita redundancia)
CREATE TABLE tipos_tela (
    id_tipo_tela INT AUTO_INCREMENT PRIMARY KEY,
    nombre_tela VARCHAR(100) NOT NULL UNIQUE,
    tipo_maquina VARCHAR(20) DEFAULT 'Ambos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Inventario de Tela (Conectado al catálogo de telas)
CREATE TABLE rollos_tela (
    id_rollo INT AUTO_INCREMENT PRIMARY KEY,
    id_tipo_tela INT NOT NULL,
    codigo_lote VARCHAR(50) DEFAULT NULL,
    cantidad_inicial INT NOT NULL DEFAULT 1,
    rollos_disponibles INT NOT NULL DEFAULT 1,
    fecha_ingreso DATE NOT NULL,
    FOREIGN KEY (id_tipo_tela) REFERENCES tipos_tela(id_tipo_tela) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Asignaciones (Asignar tela a costureras)
CREATE TABLE asignaciones_trabajo (
    id_asignacion INT AUTO_INCREMENT PRIMARY KEY,
    id_costurera INT NOT NULL,
    id_rollo INT NOT NULL, 
    rollos_utilizados INT NOT NULL,
    cantidad_asignada INT NOT NULL,
    fecha_asignacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_costurera) REFERENCES costureras(id_costurera) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_rollo) REFERENCES rollos_tela(id_rollo) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Defectos de Producción (Globales por producto)
CREATE TABLE defectos_produccion (
    id_defecto INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    fecha_registro DATE NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. Entregas de Producción (Independientes de la asignación)
CREATE TABLE entregas_produccion (
    id_entrega INT AUTO_INCREMENT PRIMARY KEY,
    id_costurera INT NULL,
    id_producto INT NOT NULL,
    cantidad_buenas INT NOT NULL DEFAULT 0,
    es_arreglo TINYINT(1) DEFAULT 0,
    fecha_entrega DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_costurera) REFERENCES costureras(id_costurera) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. Usuario Admin por defecto (Contraseña encriptada: 'admin123')
INSERT INTO usuarios_admin (nombre_completo, usuario, password) 
VALUES ('Administrador Principal', 'admin', '$2y$10$QCGjnqI2WPDjgpA/2Y8xXu3xiUrWZXxxJZ0ePTMZKVBjw9cRDL23i');

-- 10. Tipos de tela por defecto
INSERT IGNORE INTO tipos_tela (nombre_tela, tipo_maquina) VALUES 
('Manta', 'Overlock'), 
('Negro', 'Overlock');