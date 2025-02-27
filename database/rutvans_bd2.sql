-- //////////////// TABLAS PRIMARIAS (SIN DEPENDENCIAS) //////////////// --

CREATE TABLE `Localidades`(
    `idLocalidad` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `Unidades`(
    `idUnidad` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `placa` VARCHAR(255) NOT NULL,
    `capacidad` INT NOT NULL,
    `marca` VARCHAR(255) NOT NULL,
    `modelo` VARCHAR(255) NOT NULL,
    `year` INT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `Horarios`(
    `idHorario` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `horaSalida` TIME NOT NULL,
    `horaLlegada` TIME NOT NULL,
    `dia` VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `Roles`(
    `idRol` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombreRol` VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `Permisos`(
    `idPermiso` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombrePermiso` VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `Tipos_Tarifas`(
    `idTipoTarifa` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombreTarifa` VARCHAR(255) NOT NULL,
    `porcentajeTarifa` DECIMAL(10, 2) NOT NULL,
    `descripcion` TEXT NOT NULL
) ENGINE=InnoDB;

-- //////////////// TABLAS SECUNDARIAS (ÚNICAMENTE CON PRIMERAS DEPENDENCIAS) //////////////// --

CREATE TABLE `Usuarios`(
    `idUsuario` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombreUsuario` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `idRol` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `usuarios_idrol_foreign` FOREIGN KEY (`idRol`) REFERENCES `Roles`(`idRol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `Roles_Permisos`(
    `idRolPermiso` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `idRol` BIGINT UNSIGNED NOT NULL,
    `idPermiso` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `roles_permisos_idrol_foreign` FOREIGN KEY (`idRol`) REFERENCES `Roles`(`idRol`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `roles_permisos_idpermiso_foreign` FOREIGN KEY (`idPermiso`) REFERENCES `Permisos`(`idPermiso`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `Rutas`(
    `idRuta` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `idTarifa` BIGINT UNSIGNED NOT NULL,
    `idLocalidadOrigen` BIGINT UNSIGNED NOT NULL,
    `idLocalidadDestino` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `rutas_idlocalidadorigen_foreign` FOREIGN KEY(`idLocalidadOrigen`) REFERENCES `Localidades`(`idLocalidad`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `rutas_idlocalidaddestino_foreign` FOREIGN KEY(`idLocalidadDestino`) REFERENCES `Localidades`(`idLocalidad`) ON DELETE CASCADE ON UPDATE CASCADE
    -- CONSTRAINT `rutas_idtarifa_foreign` FOREIGN KEY(`idTarifa`) REFERENCES `Tarifas`(`idTarifa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- //////////////// TABLAS SECUNDARIAS (CON SEGUNDAS DEPENDENCIAS) //////////////// --

CREATE TABLE `Destinos_Intermedios`(
    `idDestinoIntermedio` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `localidadIntermedia` VARCHAR(255) NOT NULL,
    `idRuta` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `destinos_intermedios_idruta_foreign` FOREIGN KEY (`idRuta`) REFERENCES `Rutas`(`idRuta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `Ventas`(
    `idVenta` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `fecha` DATE NOT NULL,
    `folio` VARCHAR(255) NOT NULL,
    `costo` DECIMAL(10, 2) NOT NULL,
    `idUsuario` BIGINT UNSIGNED NOT NULL,
    `idOrigen` BIGINT UNSIGNED NOT NULL,
    `idEstado` BIGINT UNSIGNED NOT NULL,
    `idMetodo` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `ventas_idusuario_foreign` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios`(`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
    -- CONSTRAINT `ventas_idorigen_foreign` FOREIGN KEY (`idOrigen`) REFERENCES `Localidades`(`idLocalidad`) ON DELETE CASCADE ON UPDATE CASCADE,
    -- CONSTRAINT `ventas_idestado_foreign` FOREIGN KEY (`idEstado`) REFERENCES `Estados`(`idEstado`) ON DELETE CASCADE ON UPDATE CASCADE,
    -- CONSTRAINT `ventas_idmetodo_foreign` FOREIGN KEY (`idMetodo`) REFERENCES `Metodos`(`idMetodo`) ON DELETE CASCADE ON UPDATE CASCADE,
) ENGINE=InnoDB;

CREATE TABLE `Rutas_Unidades`(
    `idRutaUnidad` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `fecha` DATE NOT NULL,
    `idRuta` BIGINT UNSIGNED NOT NULL,
    `idUnidad` BIGINT UNSIGNED NOT NULL,
    `idHorario` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `rutas_unidades_idruta_foreign` FOREIGN KEY (`idRuta`) REFERENCES `Rutas`(`idRuta`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `rutas_unidades_idunidad_foreign` FOREIGN KEY (`idUnidad`) REFERENCES `Unidades`(`idUnidad`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `rutas_unidades_idhorario_foreign` FOREIGN KEY (`idHorario`) REFERENCES `Horarios`(`idHorario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- //////////////// TABLAS SECUNDARIAS (CON TERCERAS DEPENDENCIAS) //////////////// --

CREATE TABLE `Envios`(
    `idEnvio` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombreEmisor` VARCHAR(255) NOT NULL,
    `nombreReceptor` VARCHAR(255) NOT NULL,
    `total` DECIMAL(10, 2) NOT NULL,
    `foto` VARCHAR(255) NOT NULL,
    `descripcion` TEXT NOT NULL,
    `idRutaUnidad` BIGINT UNSIGNED NOT NULL,
    `idHorario` BIGINT UNSIGNED NOT NULL,
    `idRuta` BIGINT UNSIGNED NOT NULL,
    `idFecha` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `envios_idrutaunidad_foreign` FOREIGN KEY (`idRutaUnidad`) REFERENCES `Rutas_Unidades`(`idRutaUnidad`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `envios_idhorario_foreign` FOREIGN KEY (`idHorario`) REFERENCES `Horarios`(`idHorario`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `envios_idruta_foreign` FOREIGN KEY (`idRuta`) REFERENCES `Rutas`(`idRuta`) ON DELETE CASCADE ON UPDATE CASCADE
    -- CONSTRAINT `envios_idfecha_foreign` FOREIGN KEY (`idFecha`) REFERENCES `Fechas`(`idFecha`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `Boletos`(
    `idBoleto` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombrePasajero` VARCHAR(255) NOT NULL,
    `total` DECIMAL(10, 2) NOT NULL,
    `idRutaUnidad` BIGINT UNSIGNED NOT NULL,
    `idHorario` BIGINT UNSIGNED NOT NULL,
    `idRuta` BIGINT UNSIGNED NOT NULL,
    `idFecha` BIGINT UNSIGNED NOT NULL,
    `idDestinoIntermedio` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `boletos_idrutaunidad_foreign` FOREIGN KEY (`idRutaUnidad`) REFERENCES `Rutas_Unidades`(`idRutaUnidad`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `boletos_idhorario_foreign` FOREIGN KEY (`idHorario`) REFERENCES `Horarios`(`idHorario`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `boletos_idruta_foreign` FOREIGN KEY (`idRuta`) REFERENCES `Rutas`(`idRuta`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `boletos_iddestinointermedio_foreign` FOREIGN KEY (`idDestinoIntermedio`) REFERENCES `Destinos_Intermedios`(`idDestinoIntermedio`) ON DELETE CASCADE ON UPDATE CASCADE
    -- CONSTRAINT `boletos_idfecha_foreign` FOREIGN KEY (`idFecha`) REFERENCES `Fechas`(`idFecha`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- //////////////// TABLAS SECUNDARIAS (CON CUARTAS DEPENDENCIAS) //////////////// --

CREATE TABLE `Detalles_Boletos`(
    `idDetalleBoleto` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `numeroAsiento` INT NOT NULL,
    `precioAsiento` DECIMAL(10, 2) NOT NULL,
    `idBoleto` BIGINT UNSIGNED NOT NULL,
    `idTipoTarifa` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `detalles_boletos_idboleto_foreign` FOREIGN KEY (`idBoleto`) REFERENCES `Boletos`(`idBoleto`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `detalles_boletos_idtipotarifa_foreign` FOREIGN KEY (`idTipoTarifa`) REFERENCES `Tipos_Tarifas`(`idTipoTarifa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `Detalles_Ventas`(
    `idDetalleVenta` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombrePasajero` VARCHAR(255) NOT NULL,
    `importe` DECIMAL(10, 2) NOT NULL,
    `descuento` DECIMAL(10, 2) NOT NULL,
    `ivaTotal` DECIMAL(10, 2) NOT NULL,
    `idVenta` BIGINT UNSIGNED NOT NULL,
    `idBoleto` BIGINT UNSIGNED NOT NULL,
    `idTipoServicio` BIGINT UNSIGNED NOT NULL,
    `idEnvio` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `detalles_ventas_idboleto_foreign` FOREIGN KEY (`idBoleto`) REFERENCES `Boletos`(`idBoleto`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `detalles_ventas_idventa_foreign` FOREIGN KEY (`idVenta`) REFERENCES `Ventas`(`idVenta`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `detalles_ventas_idenvio_foreign` FOREIGN KEY (`idEnvio`) REFERENCES `Envios`(`idEnvio`) ON DELETE CASCADE ON UPDATE CASCADE
    -- CONSTRAINT `detalles_ventas_idtiposervicio_foreign` FOREIGN KEY (`idTipoServicio`) REFERENCES `Tipos_Servicios`(`idTipoServicio`) ON DELETE CASCADE ON UPDATE CASCADE,
) ENGINE=InnoDB;