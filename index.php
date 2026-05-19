<?php
//  El Servidor Perdido — Resident Evil 1

session_start();
$_SESSION['nivel']    = 1;
$_SESSION['intentos'] = 0;
$_SESSION['errores']  = 0;
$_SESSION['inicio']   = time();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Servidor Perdido — Mansión Spencer</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<!-- Fondo mansión -->
<div class="fondo-mansion"></div>

<!--TRANSICIÓN PUERTA -->
<div class="puerta-overlay" id="puerta-overlay">
    <video
        id="puerta-video"
        class="puerta-video"
        src="img/puerta.mp4"
        muted="false"
        playsinline
        preload="auto"
    ></video>
    <div class="puerta-flash" id="puerta-flash"></div>
</div>

<div class="topbar">
    <span class="topbar-left"><span class="dot"></span>S.T.A.R.S. TERMINAL</span>
    <span class="topbar-mid">MANSIÓN SPENCER — RACCOON CITY</span>
    <span class="topbar-right" id="reloj-topbar">00:00:00</span>
</div>

<!--CONTENIDO ÚNICO-->
<div class="contenedor">

    <!-- Logo + título -->
    <div class="logo-area">
        <img src="img/umbrella.jpg" alt="Umbrella Corporation" class="umbrella-logo">
        <h1>El <span>Servidor</span><br>Perdido</h1>
        <p class="texto-dim" style="margin-top:8px; letter-spacing:3px;">
            UMBRELLA CORPORATION — DATOS CLASIFICADOS
        </p>
    </div>

    <div class="sep">TRANSMISIÓN ENTRANTE</div>

    <!-- Historia + instrucciones unificadas -->
    <div class="transmision">
        <div class="encabezado-tx">
            📡 ORIGEN: LABORATORIO SUBTERRÁNEO B3 — AÑO 1998
        </div>
        <p>
            Los laboratorios subterráneos de Umbrella han sido sellados tras un accidente con el 
            <strong style="color:#b30000">Virus-T</strong>. Un servidor de respaldo contiene los datos 
            de la fórmula original, los protocolos de contención y... los responsables.
        </p>
        <p>
            El equipo Alpha de S.T.A.R.S. ha enviado tu nombre como único técnico con autorización 
            para acceder. Tienes que entrar a la Mansión Spencer, llegar al núcleo del servidor y 
            recuperar los archivos antes de que el sistema de autodestrucción se active.
        </p>
        
        <p style="color:#b30000">
            ⚠ Advertencia: No estás solo en esa mansión.
        </p>
    </div>

    <!-- Instrucciones integradas -->
    <div class="instrucciones-inline">
        <h3>— Protocolo de acceso —</h3>
        <ul>
            <li>Responde cada acertijo para avanzar al siguiente nivel de seguridad.</li>
            <li>Las respuestas están relacionadas con tecnología web y programación.</li>
            <li>Tienes <strong style="color:#b30000">máximo 3 errores</strong>. Al tercer fallo, el sistema te expulsa.</li>
            <li>Las respuestas no distinguen mayúsculas de minúsculas.</li>
            <li>El servidor tiene <strong>5 niveles</strong> de encriptación que superar.</li>
        </ul>
    </div>

    <div class="sep">ESTADO DE MISIÓN</div>

    <div class="stats-row">
        <div class="stat-item">
            <span class="stat-valor">05</span>
            <span class="stat-label">Niveles</span>
        </div>
        <div class="stat-item">
            <span class="stat-valor" style="color:#b30000">03</span>
            <span class="stat-label">Vidas</span>
        </div>
        <div class="stat-item">
            <span class="stat-valor">🔐</span>
            <span class="stat-label">Encriptado</span>
        </div>
    </div>

    <hr class="linea-divisora">

    <p class="texto-dim" style="margin-bottom:22px; letter-spacing:1px;">
        Presiona el botón para entrar a la mansión.<br>
        El servidor está esperando tu acceso.
    </p>

    <!--activa video puerta y navega-->
    <button class="boton" onclick="activarPuerta('juego.php')">
        ▶ INGRESAR A LA MANSIÓN
    </button>

</div>

<script src="script.js"></script>
</body>
</html>
