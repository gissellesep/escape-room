<?php

$servidor   = "localhost";
$usuario    = "root";
$password   = "";
$base_datos = "escape_room";

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conexion->connect_error) {
    die("
        <div style='font-family:monospace;background:#0d1117;color:#ff4d4d;
                    padding:30px;text-align:center;min-height:100vh;'>
            <h2>⚠️ ERROR DE CONEXIÓN</h2>
            <p>" . $conexion->connect_error . "</p>
            <p>Verifica que el servidor MySQL esté activo y la base de datos exista.</p>
        </div>
    ");
}

$conexion->set_charset("utf8mb4");
?>
