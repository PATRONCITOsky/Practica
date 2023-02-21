Para hacer uso de este programa necesita realizar los siguientes pasos:

1-> Modificar las credenciales que hacen posible la conexion a la BD, 
    recordar que bajo ningun motivo el usuario debe ser root y la contraseña vacia,
    vale la pena aclarar que en este ejercio se relizo esta mala practica por ser una prueba
    y comodidad.

2->Crear la BD para ello se puede hacer uso de la tabla brindada en la carpeta BD o copiar el 
    siguiente codigo SQL:

    CREATE DATABASE usando_sql;

    USE usando_sql;

    CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    correo_electronico VARCHAR(150),
    contraseña VARCHAR(150)
    );

    INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `contraseña`) VALUES
    (1, 'Hoover', 'Hernández', 'h2verhernandez@gmail.com', '666'),
    (2, 'Santiago', 'Becerra', 'santi@gmail.com', '111'),
    (3, 'Julian', 'Agudelo', 'juli@gmail.com', '222'),
    (4, 'Ruby', 'Blando', 'ruby@gmail.com', '333'),
    (5, 'Angie', 'Becerra', 'angie@gmail.com', '444'),
    (6, 'Brando', 'Rangel', 'brandon@gmail.com', '12345678'),
    (7, 'Hoover', 'Hernandez', 'hhernandez@gmail.com', '12345678');

    //Esta consulta permite seleccionar todos los registros de la tabla usuarios
    SELECT * FROM usuarios WHERE 1;

    //Consulta SQL para actulizar un registro de la tabla usuarios
    UPDATE usuarios SET contraseña = 'nueva123456' WHERE id = 3;

    //Consulta para eliminar un registro de la tabla usuario
    DELETE FROM usuarios WHERE id = 5;
