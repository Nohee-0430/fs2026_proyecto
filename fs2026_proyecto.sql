CREATE DATABASE if NOT EXISTS fs2026_proyecto;
USE fs2026_proyecto;

CREATE TABLE clientes(
	cliente_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nombre VARCHAR(150) NOT NULL,
	correo VARCHAR(150) NOT NULL,
	contrasenia VARCHAR(150) NOT NULL,
	fecha_registro DATE NOT NULL
);

CREATE TABLE empleados(
	empleado_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nombre VARCHAR(150) NOT NULL,
	correo VARCHAR(150) NOT NULL,
	contrasenia VARCHAR(150) NOT NULL,
	rol VARCHAR(150) NOT NULL,
	fecha_registro DATE NOT NULL
);

CREATE TABLE categorias(
		categoria_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
		nombre VARCHAR(150) NOT NULL,
		descripcion VARCHAR(350) NOT NULL
);

CREATE TABLE productos(
		producto_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
		categoria_id INT UNSIGNED NOT NULL,
		nombre VARCHAR(150) NOT NULL,
		descripcion VARCHAR(350) NOT NULL,
		imagen VARCHAR(500) NOT NULL,
		precio DECIMAL(10,2) NOT NULL,
		stock INT NOT NULL,
		disponible BOOLEAN NOT NULL,
		
		CONSTRAINT producto_categoria_id_fk FOREIGN KEY (categoria_id)
		REFERENCES categorias(categoria_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
);

CREATE TABLE carritos(
		carrito_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
		cliente_id INT UNSIGNED NOT NULL,
		fecha_creacion DATE NOT NULL,
		estado VARCHAR(150) NOT NULL,
		
		CONSTRAINT carrito_cliente_id_fk FOREIGN KEY (cliente_id)
		REFERENCES clientes(cliente_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
);

CREATE TABLE detalle_carrito(
		detalle_carrito_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
		carrito_id INT UNSIGNED NOT NULL,
		producto_id INT UNSIGNED NOT NULL,
		cantidad INT NOT NULL,
		precio_unitario DECIMAL(10,2) NOT NULL,
		
		CONSTRAINT detalle_carrito_carrito_id_fk FOREIGN KEY (carrito_id)
		REFERENCES carritos(carrito_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
		
		CONSTRAINT detalle_carrito_producto_id_fk FOREIGN KEY (producto_id)
		REFERENCES productos(producto_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
);

CREATE TABLE pedidos(
		carrito_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
		cliente_id INT UNSIGNED NOT NULL,
		empleado_id INT UNSIGNED NOT NULL,
		fecha_pedido DATE NOT NULL,
		total DECIMAL(10,2) NOT NULL,
		estado VARCHAR(150) NOT NULL,
		nit VARCHAR(20) NOT NULL,
		metodo_pago VARCHAR(80) NOT NULL,
		tipo_entrega VARCHAR(150) NOT NULL,
		
		CONSTRAINT pedido_cliente_id_fk FOREIGN KEY (cliente_id)
		REFERENCES clientes(cliente_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
		
		CONSTRAINT pedido_empleado_id_fk FOREIGN KEY (empleado_id)
		REFERENCES empleados(empleado_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
);

CREATE TABLE detalle_pedido(
		detalle_pedido_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
		carrito_id INT UNSIGNED NOT NULL,
		producto_id INT UNSIGNED NOT NULL,
		cantidad INT NOT NULL,
		precio_unitario DECIMAL(10,2) NOT NULL,
		subtotal DECIMAL(10,2) NOT NULL,
		
		CONSTRAINT detalle_pedido_pedido_id_fk FOREIGN KEY (carrito_id)
		REFERENCES pedidos(carrito_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
		
		CONSTRAINT detalle_pedido_producto_id_fk FOREIGN KEY (producto_id)
		REFERENCES productos(producto_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
);

CREATE TABLE envios(
		pedido_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
		carrito_id INT UNSIGNED NOT NULL,
		direccion VARCHAR(350) NOT NULL,
		municipio VARCHAR(100) NOT NULL,
		departamento VARCHAR(100) NOT NULL,
		referencia_ubicacion VARCHAR(500) NOT NULL,
		observaciones VARCHAR(700) NOT NULL,
		total_cobrar VARCHAR(500) NOT NULL,
		estado_envio VARCHAR(150) NOT NULL,
		numero_seguimiento VARCHAR(15) NOT NULL,
		fecha_envio DATE NOT NULL,
		fecha_entrega DATE NOT NULL,
		
		CONSTRAINT envio_pedido_id_fk FOREIGN KEY (carrito_id)
		REFERENCES pedidos(carrito_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
);

CREATE TABLE resenias(
		resenia_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
		cliente_id INT UNSIGNED NOT NULL,
		detalle_pedido_id INT UNSIGNED NOT NULL,
		calificacion DECIMAL(2,1) NOT NULL,
		comentario VARCHAR(500) NOT NULL,
		estado VARCHAR(50) NOT NULL,
		fecha_publicacion DATE NOT NULL,
		
		CONSTRAINT resenias_cliente_id_fk FOREIGN KEY (cliente_id)
		REFERENCES clientes(cliente_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
		
		CONSTRAINT resenias_detalle_pedido_id_fk FOREIGN KEY (detalle_pedido_id)
		REFERENCES detalle_pedido(detalle_pedido_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE 
);

CREATE TABLE lista_deseos(
		lista_deseo_id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
		cliente_id INT UNSIGNED NOT NULL,
		producto_id INT UNSIGNED NOT NULL,
		fecha_agregado DATE NOT NULL, 
		
		CONSTRAINT lista_cliente_id_fk FOREIGN KEY (cliente_id)
		REFERENCES clientes(cliente_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
		
		CONSTRAINT lista_producto_id_fk FOREIGN KEY (producto_id)
		REFERENCES productos(producto_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
);
