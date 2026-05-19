<?php
//Pantalla de victoria

session_start();

$intentos = isset($_SESSION['intentos']) ? (int)$_SESSION['intentos'] : 0;
$errores  = isset($_SESSION['errores'])  ? (int)$_SESSION['errores']  : 0;
$inicio   = isset($_SESSION['inicio'])   ? (int)$_SESSION['inicio']   : time();

$seg   = time() - $inicio;
$min   = floor($seg / 60);
$segs  = $seg % 60;
$tiempo = sprintf('%02d:%02d', $min, $segs);

$niveles   = 5;
$precision = ($intentos > 0) ? min(100, round(($niveles / $intentos) * 100)) : 100;

if ($errores === 0) {
    $rango = 'S — CHRIS REDFIELD';
    $desc  = 'Sin un solo error. Eres el miembro perfecto de S.T.A.R.S.';
} elseif ($errores === 1) {
    $rango = 'A — JILL VALENTINE';
    $desc  = 'Casi perfecto. Jill Valentine estaría orgullosa.';
} elseif ($errores === 2) {
    $rango = 'B — BARRY BURTON';
    $desc  = 'Bien hecho. Barry te diría: "This is really happening, huh?"';
} else {
    $rango = 'C — REBECCA CHAMBERS';
    $desc  = 'Lograste el objetivo. Pero los zombies casi te alcanzan.';
}

session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivos Recuperados — El Servidor Perdido</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="fondo-mansion"></div>

<div class="topbar">
    <span class="topbar-left"><span class="dot"></span>MISIÓN COMPLETADA</span>
    <span class="topbar-mid">ARCHIVOS RECUPERADOS — OPERACIÓN EXITOSA</span>
    <span class="topbar-right" id="reloj-topbar">00:00:00</span>
</div>

<!--CONTENIDO-->
<div class="contenedor">

    <img src="img/umbrella.jpg" alt="Umbrella Corp" class="umbrella-logo">

    <h1 class="victoria-titulo">
        Archivos<br><span>Recuperados</span>
    </h1>

    <p style="font-family:'Share Tech Mono',monospace; font-size:0.65rem;
              color:var(--crema); letter-spacing:1px; margin:12px 0 20px; line-height:2;">
        Has superado todos los niveles de seguridad del servidor.<br>
        Los datos del Proyecto Virus-T han sido extraídos con éxito.<br>
        <span style="color:#b30000">Umbrella no podrá ocultarlos por más tiempo.</span>
    </p>

    <div class="sep">INFORME FINAL — S.T.A.R.S.</div>

    <!-- Rango -->
    <div class="rango-bloque">
        <div class="rango-titulo">▶ RANGO OBTENIDO</div>
        <div class="rango-valor">RANK <?php echo $rango; ?></div>
        <div class="rango-desc"><?php echo $desc; ?></div>
    </div>

    <!-- Log -->
    <div class="log-final">
        > INFORME_OPERACION.log<br>
        > Niveles completados: <span>5 / 5 ✔</span><br>
        > Intentos totales:    <span><?php echo $intentos; ?></span><br>
        > Errores cometidos:   <span><?php echo $errores; ?> / 3</span><br>
        > Tiempo de misión:    <span><?php echo $tiempo; ?> min</span><br>
        > Precisión:           <span><?php echo $precision; ?>%</span><br>
        > Estado:              <span>DATOS EXTRAÍDOS — OPERACIÓN EXITOSA ✔</span>
    </div>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-item">
            <span class="stat-valor"><?php echo $intentos; ?></span>
            <span class="stat-label">Intentos</span>
        </div>
        <div class="stat-item">
            <span class="stat-valor"><?php echo $tiempo; ?></span>
            <span class="stat-label">Tiempo</span>
        </div>
        <div class="stat-item">
            <span class="stat-valor"><?php echo $precision; ?>%</span>
            <span class="stat-label">Precisión</span>
        </div>
    </div>

    <hr class="linea-divisora">

    <a href="index.php" class="boton">▶ NUEVA MISIÓN</a>

</div>

<script src="script.js"></script>
</body>
</html>
