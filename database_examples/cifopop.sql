-- Base de datos limpia para el framework FastLight.
-- Servirá como punto de partida de los proyectos FastLight.

-- se incluye:
--  la tabla para usuarios, con algunos usuarios para pruebas.
--  la tabla errores, permite registrar los errores de la aplicación en BDD.
--  la tabla stats, para contar las visitas de cada URL de la aplicación.

-- Última modificación: 19/12/2024


DROP DATABASE IF EXISTS cifopop;

CREATE DATABASE cifopop DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE cifopop;

-- tabla users
-- se pueden crear campos adicionales o relaciones con otras entidadessi es necesario
CREATE TABLE users(
	id INT PRIMARY KEY auto_increment,
	displayname VARCHAR(32) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE KEY,
	phone VARCHAR(32) NOT NULL UNIQUE KEY,
    cp CHAR(5) NOT NULL,
    poblacion VARCHAR(64) NOT NULL,
	password VARCHAR(255) NOT NULL,
	roles VARCHAR(1024) NOT NULL DEFAULT '["ROLE_USER"]',
	picture VARCHAR(256) DEFAULT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- creación de la tabla "anuncios"
CREATE TABLE anuncios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  iduser INT NOT NULL,
  titulo VARCHAR(256) NOT NULL COMMENT 'Título del anuncio',
  precio FLOAT NOT NULL DEFAULT 0 COMMENT 'precio del artículo',
  descripcion VARCHAR(256) DEFAULT NULL COMMENT 'Descripción del artículo ofertado', 
  imagen VARCHAR(256) NULL DEFAULT NULL COMMENT 'Foto del artículo anunciado',
  
  -- definición de la clave foránea
  -- se podrán eliminar libros con ejemplares (CASCADE), pero solo si no hay préstamos
  -- para ello restringiremos la eliminación (RESTRICT) en la relación entre ejemplar y préstamo
  FOREIGN KEY (iduser) REFERENCES users(id) 
		ON UPDATE CASCADE ON DELETE CASCADE
);


-- usuarios para las pruebas, podéis crear tantos como necesitéis
INSERT INTO users(id, displayname, email, phone, picture, password, roles, cp, poblacion) VALUES 
	(1, 'admin', 'admin@fastlight.org', '666666661', 'admin.png', md5('1234'), '["ROLE_USER", "ROLE_ADMIN"]', 08205, 'Sabadell'),
	(2, 'editor', 'editor@fastlight.org', '666666662', NULL, md5('1234'), '["ROLE_USER", "ROLE_EDITOR"]', 08205, 'Sabadell'),
	(3, 'user', 'user@fastlight.org', '666666663', 'user.png', md5('1234'), '["ROLE_USER"]', 08205, 'Sabadell'),
	(4, 'test', 'test@fastlight.org', '666666664', 'test.png', md5('1234'), '["ROLE_USER", "ROLE_TEST"]', 08205, 'Sabadell'),
	(5, 'api', 'api@fastlight.org', '666666665', NULL, md5('1234'), '["ROLE_API"]', 08205, 'Sabadell'),
    (6, 'blocked', 'blocked@fastlight.org', '666666666', NULL, md5('1234'), '["ROLE_USER", "ROLE_BLOCKED"]', 08205, 'Sabadell'),
    (7, 'Robert', 'robert@fastlight.org', '666666667', NULL, md5('1234'), '["ROLE_USER", "ROLE_ADMIN", "ROLE_TEST"]', 08205, 'Sabadell')
;

-- anuncios para las pruebas
INSERT INTO anuncios(id, iduser, titulo, precio, descripcion) VALUES
	(1, 4, 'Margaritas to bonitas', 12, 'Un ramo de flores to bonicas'),
	(2, 5, 'Nissan Terrano', 1500, 'El mejor buga de tu vida, chaval'),
	(3, 7, 'Animal Crossing', 25, 'La droga dura de los juegos de gestion'),
	(4, 3, 'Vajilla duralex', 20, 'Es como la vajilla de tu abuela. Puede que sea la vajilla de tu abuela, por que esto no se rompe nunca.')
	;

-- tabla errors
-- por si queremos registrar los errores en base de datos.
CREATE TABLE errors(
	id INT PRIMARY KEY auto_increment,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    level VARCHAR(32) NOT NULL DEFAULT 'ERROR',
    url VARCHAR(256) NOT NULL,
	message VARCHAR(2048) NOT NULL,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL
);


-- tabla stats
-- por si queremos registrar las estadísticas de visitas a las disintas URLs de nuestra aplicación.
CREATE TABLE stats(
	id INT PRIMARY KEY auto_increment,
    url VARCHAR(250) NOT NULL UNIQUE KEY,
	count INT NOT NULL DEFAULT 1,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL, 
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

