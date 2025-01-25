CREATE TABLE Cliente (
    idCliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    telefono VARCHAR(20)
);

CREATE TABLE Producto (
    idProducto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    stockGramos INT NOT NULL
);

CREATE TABLE Cita (
    idCita INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    idCliente INT NOT NULL,
    costes DECIMAL(10, 2),
    cobro DECIMAL(10, 2),
    FOREIGN KEY (idCliente) REFERENCES Cliente(idCliente) ON DELETE CASCADE
);

CREATE TABLE CitaProducto (
    idCitaR INT NOT NULL,
    idProductoR INT NOT NULL,  -- Allow NULL values for idProducto -- CAMBIADO DE UNIQUE A NULL
    cantidad INT,
    FOREIGN KEY (idCitaR) REFERENCES Cita(idCita) ON DELETE CASCADE,
    FOREIGN KEY (idProductoR) REFERENCES Producto(idProducto) ON DELETE CASCADE
); 