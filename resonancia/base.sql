CREATE DATABASE PruebaRedSocial;
USE PruebaRedsocial;

CREATE TABLE usuarios(
    ID_Usuario int PRIMARY KEY AUTO_INCREMENT,
    nombre varchar(100) NOT NULL,
    usuario varchar(100) NOT NULL,
    descripcion text,
    email varchar(100) NOT NULL,
    contraseña varchar(250) NOT NULL,
    privilegios char(1)
);

CREATE TABLE publicaciones (
    ID_Publicacion int PRIMARY KEY AUTO_INCREMENT,
    ID_Usuario int NOT NULL,
    FOREIGN KEY (ID_Usuario) REFERENCES usuarios(ID_Usuario) ON UPDATE CASCADE ON DELETE CASCADE,
    contenido text NOT NULL,
    imagen longblob,
    fecha timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE notificaciones(
    ID_Notificacion int PRIMARY KEY AUTO_INCREMENT,
    ID_Usuario int NOT NULL,
    FOREIGN KEY (ID_Usuario) REFERENCES usuarios(ID_Usuario) ON UPDATE CASCADE ON DELETE CASCADE,
    mensaje text,
    fecha timestamp DEFAULT CURRENT_TIMESTAMP,
    leida boolean DEFAULT false
);

CREATE TABLE mensajes(
    ID_Mensaje int PRIMARY KEY AUTO_INCREMENT,
    ID_Remitente int NOT NULL,
    FOREIGN KEY (ID_Remitente) REFERENCES usuarios(ID_Usuario) ON UPDATE CASCADE ON DELETE CASCADE,
    ID_Destinatario int NOT NULL,
    FOREIGN KEY (ID_Destinatario) REFERENCES usuarios(ID_Usuario) ON UPDATE CASCADE ON DELETE CASCADE,
    contenido text,
    fecha timestamp DEFAULT CURRENT_TIMESTAMP,
    leido boolean DEFAULT false
);

CREATE TABLE comentarios(
    ID_Comentario int PRIMARY KEY AUTO_INCREMENT,
    ID_Usuario int NOT NULL,
    FOREIGN KEY (ID_Usuario) REFERENCES usuarios(ID_Usuario) ON UPDATE CASCADE ON DELETE CASCADE,
    ID_Mensaje int NOT NULL,
    FOREIGN KEY (ID_Mensaje) REFERENCES mensajes(ID_Mensaje) ON UPDATE CASCADE ON DELETE CASCADE,
    contenido text,
    fecha timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE canciones(
    ID_Cancion int PRIMARY KEY AUTO_INCREMENT,
    ID_Usuario int NOT NULL,
    FOREIGN KEY (ID_Usuario) REFERENCES usuarios(ID_Usuario) ON UPDATE CASCADE ON DELETE CASCADE,
    titulo varchar(250) NOT NULL,
    artista varchar(250) NOT NULL,
    duracion time NOT NULL,
    caratula longblob NOT NULL,
    genero varchar(50) NOT NULL,
    fecha_publicacion timestamp DEFAULT CURRENT_TIMESTAMP,
    archivo_ruta varchar(100)
);

CREATE TABLE playlists(
    ID_Playlist int PRIMARY KEY AUTO_INCREMENT,
    ID_Usuario int NOT NULL,
    FOREIGN KEY (ID_Usuario) REFERENCES usuarios(ID_Usuario) ON UPDATE CASCADE ON DELETE CASCADE,
    nombre varchar(100),
    descripcion text
);

CREATE TABLE playlists_canciones(
    ID_Playlist int NOT NULL,
    ID_Cancion int NOT NULL,
    PRIMARY KEY (ID_Playlist, ID_Cancion),
    FOREIGN KEY (ID_Playlist) REFERENCES playlists(ID_Playlist) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (ID_Cancion) REFERENCES canciones(ID_Cancion) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE likes(
    ID_Like int PRIMARY KEY AUTO_INCREMENT,
    ID_Usuario int NOT NULL,
    FOREIGN KEY (ID_Usuario) REFERENCES usuarios(ID_Usuario) ON UPDATE CASCADE ON DELETE CASCADE,
    ID_Publicacion int,
    FOREIGN KEY (ID_Publicacion) REFERENCES publicaciones(ID_Publicacion) ON UPDATE CASCADE ON DELETE CASCADE,
    ID_Comentario int,
    FOREIGN KEY (ID_Comentario) REFERENCES comentarios(ID_Comentario) ON UPDATE CASCADE ON DELETE CASCADE,
    ID_Cancion int,
    FOREIGN KEY (ID_Cancion) REFERENCES canciones(ID_Cancion) ON UPDATE CASCADE ON DELETE CASCADE,
    ID_Playlist int,
    FOREIGN KEY (ID_Playlist) REFERENCES playlists(ID_Playlist) ON UPDATE CASCADE ON DELETE CASCADE
);
    

GRANT ALL PRIVILEGES ON resonancia.* TO 'root'@'localhost' IDENTIFIED BY '';
flush privileges;
