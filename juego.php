<?php
//  juego.php — Lógica principal del juego
//  El Servidor Perdido — Resident Evil 1
session_start();
include('conexion.php');

if (!isset($_SESSION['nivel']))    { $_SESSION['nivel']    = 1; }
if (!isset($_SESSION['intentos'])) { $_SESSION['intentos'] = 0; }
if (!isset($_SESSION['errores']))  { $_SESSION['errores']  = 0; }
if (!isset($_SESSION['inicio']))   { $_SESSION['inicio']   = time(); }

$nivel      = $_SESSION['nivel'];
$errores    = $_SESSION['errores'];
$maxErrores = 3;
$mensaje    = '';
$tipo       = '';
$mostrar_go = false;

// Total pistas
$res_total    = $conexion->query("SELECT COUNT(*) as total FROM pistas");
$total_pistas = (int)$res_total->fetch_assoc()['total'];

// Procesar POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resp = trim($_POST['respuesta'] ?? '');
    $n    = (int)$nivel;
    $res  = $conexion->query("SELECT * FROM pistas WHERE orden = $n");

    if ($res && $res->num_rows > 0) {
        $pista_val = $res->fetch_assoc();
        $_SESSION['intentos']++;

        if (strcasecmp($resp, $pista_val['respuesta']) === 0) {
            // ✔ Correcto
            $mensaje = '✔ ' . $pista_val['mensaje_exito'];
            $tipo    = 'exito';
            $_SESSION['nivel']++;
            $nivel = $_SESSION['nivel'];
            $n2    = (int)$nivel;
            $check = $conexion->query("SELECT * FROM pistas WHERE orden = $n2");
            if (!$check || $check->num_rows === 0) {
                header('Location: final.php'); exit();
            }
        } else {
            // ✖ Incorrecto
            $_SESSION['errores']++;
            $errores = $_SESSION['errores'];
            $tipo    = 'error';

            if ($errores >= $maxErrores) {
                $mostrar_go = true;
                $mensaje    = '¡ALERTA! Has cometido 3 errores. El sistema está furioso.';
            } else {
                $rest    = $maxErrores - $errores;
                $mensaje = '✖ Acceso denegado. Respuesta incorrecta. Te quedan ' . $rest . ' intento(s).';
            }
        }
    }
}

// Cargar pista
$n         = (int)$nivel;
$resultado = $conexion->query("SELECT * FROM pistas WHERE orden = $n");
if (!$resultado || $resultado->num_rows === 0) {
    header('Location: final.php'); exit();
}
$pista      = $resultado->fetch_assoc();
$errores    = $_SESSION['errores'];
$porcentaje = round((($nivel - 1) / $total_pistas) * 100);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sector <?php echo str_pad($nivel,2,'0',STR_PAD_LEFT); ?> — El Servidor Perdido</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="fondo-mansion"></div>

<!-- MODAL GAME OVER-->
<?php if ($mostrar_go): ?>
<div class="modal-gameover visible" id="modal-gameover">

    <!-- AUDIO GAME OVER -->
    <audio id="audio-gameover" autoplay>
        <source src="audio/stars.mp3" type="audio/mpeg">
    </audio>

    <div class="gameover-box">

        <img src="img/zombie_error.jpg"
             alt="Zombie del laboratorio"
             class="gameover-zombie">

        <div class="gameover-titulo">
            ¡Némesis te encontró!
        </div>

        <div class="gameover-texto">
            Nemesis localizó tu posición dentro del laboratorio.<br>
            El protocolo de contención ha fallado.<br>
            No hubo sobrevivientes.
        </div>

        <button class="boton gameover-btn"
                onclick="cerrarGameOver()">
            ▶ REINICIAR MISIÓN (si te atreves)
        </button>

    </div>
</div>
<?php endif; ?>

<!--TRANSICIÓN PUERTA-->
<div class="puerta-overlay" id="puerta-overlay">
    <video
        id="puerta-video"
        class="puerta-video"
        src="img/puerta.mp4"
        playsinline
        preload="auto"
    ></video>
    <div class="puerta-flash" id="puerta-flash"></div>
</div>

<div class="topbar">
    <span class="topbar-left">
        <span class="dot"></span>NIVEL <?php echo $nivel; ?>/<?php echo $total_pistas; ?>
    </span>
    <span class="topbar-mid">MANSIÓN SPENCER — SECTOR <?php echo $nivel; ?></span>
    <span class="topbar-right" id="reloj-topbar">00:00:00</span>
</div>

<!-- CONTENIDO -->
<div class="contenedor">

    <div class="logo-area">
        <span class="logo-icono">🔐</span>
        <h1>Sector <span><?php echo str_pad($nivel,2,'0',STR_PAD_LEFT); ?></span></h1>
        <p class="texto-dim" style="letter-spacing:3px; margin-top:4px;">
            NIVEL DE ACCESO: <?php echo $nivel; ?> DE <?php echo $total_pistas; ?>
        </p>
    </div>

    <!-- Barra de progreso -->
    <div class="barra-nivel-wrap">
        <div class="barra-nivel-label">
            <span>PROGRESO DE RECUPERACIÓN</span>
            <span id="barra-label"><?php echo $porcentaje; ?>% RECUPERADO</span>
        </div>
        <div class="barra-nivel-bg">
            <div class="barra-nivel-fill" id="barra-fill"
                 style="width:<?php echo $porcentaje; ?>%"></div>
        </div>
    </div>

    <!-- Vidas -->
    <div class="vidas-wrap">
        <span class="vida-label">VIDAS:</span>
        <?php for ($i = 1; $i <= 3; $i++): ?>
            <span class="corazon <?php echo ($i <= $errores) ? 'perdido' : ''; ?>">❤</span>
        <?php endfor; ?>
    </div>

    <!-- Mensaje -->
    <?php if ($mensaje !== ''): ?>
        <div class="mensaje-<?php echo $tipo; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <div class="sep">ARCHIVO CLASIFICADO</div>

    <!-- Pista -->
    <div class="pista">
        <h2>Acertijo del Sistema</h2>
        <p><?php echo htmlspecialchars($pista['pregunta']); ?></p>
    </div>

    <!-- Formulario -->
    <div class="form-respuesta">
        <form method="POST" onsubmit="return validarFormulario();">
            <input
                type="text"
                name="respuesta"
                id="respuesta"
                placeholder="_ INTRODUCE TU RESPUESTA _"
                autocomplete="off"
                spellcheck="false"
            >
            <button type="submit">▶ ENVIAR RESPUESTA</button>
        </form>
    </div>

    <hr class="linea-divisora">

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-item">
            <span class="stat-valor"><?php echo $nivel; ?>/<?php echo $total_pistas; ?></span>
            <span class="stat-label">Sector</span>
        </div>
        <div class="stat-item">
            <span class="stat-valor"><?php echo $_SESSION['intentos']; ?></span>
            <span class="stat-label">Intentos</span>
        </div>
        <div class="stat-item">
            <span class="stat-valor" style="color:#b30000">
                <?php echo $errores; ?>/3
            </span>
            <span class="stat-label">Errores</span>
        </div>
    </div>

    <br>
    <a href="index.php" class="boton boton-secundario">↩ ABANDONAR MISIÓN</a>

</div>

<script src="script.js"></script>
<script>
    actualizarBarra(<?php echo $nivel; ?>, <?php echo $total_pistas; ?>);

    <?php if ($tipo === 'error' && !$mostrar_go): ?>
    // Reproducir error con fade de volumen
    reproducirError();
    <?php endif; ?>

    <?php if ($mostrar_go): ?>

setTimeout(() => {

    const audio = document.getElementById("audio-gameover");

    if (audio) {
        audio.volume = 1;
        audio.play().catch(e => console.log(e));
    }

}, 300);

<?php endif; ?>
</script>
</body>
</html>
