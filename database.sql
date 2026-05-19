DROP TABLE IF EXISTS pistas;

CREATE TABLE pistas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta TEXT NOT NULL,
    respuesta VARCHAR(100) NOT NULL,
    mensaje_exito TEXT NOT NULL,
    orden INT NOT NULL
);

INSERT INTO pistas (pregunta, respuesta, mensaje_exito, orden) VALUES
(
    'Soy la estructura principal de una página web. Sin mí, no hay etiquetas ni contenido ordenado. Soy el esqueleto que da forma a todo lo que ves en el navegador. ¿Quién soy?',
    'HTML',
    '✅ Acceso concedido. Has restaurado la capa de estructura del servidor. El primer bloque de datos ha sido recuperado.',
    1
),
(
    'Soy el lenguaje que da color, forma y estilo a una página web. Sin mí, todo sería texto plano y aburrido. Los diseñadores me aman. ¿Quién soy?',
    'CSS',
    '✅ Nivel superado. La capa de presentación ha sido desbloqueada. Los archivos de diseño están de vuelta en línea.',
    2
),
(
    'Trabajo del lado del cliente y puedo validar formularios, mostrar alertas o cambiar elementos de la página sin recargarla. Soy el lenguaje de la interactividad web. ¿Quién soy?',
    'JavaScript',
    '✅ Excelente. La capa de comportamiento ha sido restaurada. El motor de scripts del servidor vuelve a funcionar.',
    3
),
(
    'Vivo en el servidor, proceso formularios y puedo conectarme a bases de datos. Genero HTML de forma dinámica y soy muy popular en el desarrollo web del lado del servidor. ¿Quién soy?',
    'PHP',
    '✅ ¡Increíble! La capa del servidor ha sido recuperada. Estás muy cerca del núcleo del sistema.',
    4
),
(
    'Soy un sistema de gestión de base de datos relacional de código abierto. Almaceno datos en tablas con filas y columnas, y uso SQL para consultarme. Sin mí, los datos se perderían. ¿Quién soy?',
    'MySQL',
    '✅ ¡ACCESO TOTAL CONCEDIDO! Has restaurado el núcleo del servidor. Todos los archivos han sido recuperados con éxito.',
    5
);
