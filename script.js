const STORAGE_KEY_TIME   = 're1_music_time';
const STORAGE_KEY_ACTIVE = 're1_music_active';

const audioMusica = new Audio('audio/musica.mp3');
audioMusica.loop   = true;
audioMusica.volume = 0.55;

const audioError  = new Audio('audio/error.mp3');
audioError.volume  = 1.0;

const audioStars = new Audio('audio/stars.mp3');
audioStars.volume = 1.0;


function iniciarMusica() {
    
    const savedTime   = parseFloat(sessionStorage.getItem(STORAGE_KEY_TIME)  || '0');
    const wasActive   = sessionStorage.getItem(STORAGE_KEY_ACTIVE) === '1';

    if (!isNaN(savedTime) && savedTime > 0) {
        audioMusica.currentTime = savedTime;
    }

    audioMusica.play().catch(() => {
       
        const retry = () => {
            audioMusica.play().catch(() => {});
            document.removeEventListener('click',   retry);
            document.removeEventListener('keydown', retry);
            document.removeEventListener('touchstart', retry);
        };
        document.addEventListener('click',      retry, { once: true });
        document.addEventListener('keydown',    retry, { once: true });
        document.addEventListener('touchstart', retry, { once: true });
    });

    sessionStorage.setItem(STORAGE_KEY_ACTIVE, '1');
}

function guardarTiempoMusica() {
    if (!audioMusica.paused) {
        sessionStorage.setItem(STORAGE_KEY_TIME, String(audioMusica.currentTime));
    }
}

window.addEventListener('beforeunload', guardarTiempoMusica);
window.addEventListener('pagehide',     guardarTiempoMusica);


function reproducirError() {
    const volOriginal = audioMusica.volume;
    const volBajo     = 0.10;
    const pasos       = 12;

    // Bajar rápido
    let i = 0;
    const bajada = setInterval(() => {
        i++;
        audioMusica.volume = Math.max(volBajo,
            volOriginal - (volOriginal - volBajo) * (i / pasos));
        if (i >= pasos) clearInterval(bajada);
    }, 15);

    // Reproducir error
    audioError.currentTime = 0;
    audioError.play().catch(() => {});

    // Subir cuando termine
    audioError.onended = () => {
        let j = 0;
        const subida = setInterval(() => {
            j++;
            audioMusica.volume = Math.min(volOriginal,
                volBajo + (volOriginal - volBajo) * (j / pasos));
            if (j >= pasos) clearInterval(subida);
        }, 25);
    };
}


function reproducirStars() {
    const volBajo = 0.10;
    const pasos   = 12;

    // Forzar volumen bajo sin esperar que suba primero
    audioMusica.volume = volBajo;

    audioStars.currentTime = 0;
    audioStars.play().catch(() => {});

    audioStars.onended = () => {
        let j = 0;
        const volObjetivo = 0.55;
        const subida = setInterval(() => {
            j++;
            audioMusica.volume = Math.min(volObjetivo,
                volBajo + (volObjetivo - volBajo) * (j / pasos));
            if (j >= pasos) clearInterval(subida);
        }, 25);
    };
}


function activarPuerta(destino) {
    const overlay = document.getElementById('puerta-overlay');
    const vid     = document.getElementById('puerta-video');
    const flash   = document.getElementById('puerta-flash');

    if (!overlay || !vid) {
        window.location.href = destino;
        return;
    }

    
    guardarTiempoMusica();

    overlay.classList.add('visible');

    
    vid.currentTime = 0;
    vid.play().catch(() => {});


    const duracion = vid.duration || 6.3;
    setTimeout(() => {
        if (flash) flash.classList.add('activo');
    }, (duracion - 0.4) * 1000);


    vid.onended = () => {
        window.location.href = destino;
    };

    
    setTimeout(() => {
        window.location.href = destino;
    }, (duracion + 0.8) * 1000);
}

function validarFormulario() {
    const inp = document.getElementById('respuesta');
    if (!inp || inp.value.trim() === '') {
        mostrarAlertaInline('⚠ Debes ingresar una respuesta antes de continuar.');
        if (inp) inp.focus();
        return false;
    }
    const btn = document.querySelector('button[type="submit"]');
    if (btn) { btn.textContent = 'Analizando...'; btn.disabled = true; }
    return true;
}

function mostrarAlertaInline(msg) {
    const ant = document.getElementById('alerta-js');
    if (ant) ant.remove();
    const div = document.createElement('div');
    div.id = 'alerta-js';
    div.className = 'mensaje-error';
    div.textContent = msg;
    const form = document.querySelector('.form-respuesta');
    if (form) form.appendChild(div);
    setTimeout(() => { if (div.parentNode) div.remove(); }, 4000);
}

function actualizarBarra(nivelActual, totalNiveles) {
    const fill  = document.getElementById('barra-fill');
    const label = document.getElementById('barra-label');
    if (!fill) return;
    const pct = Math.round(((nivelActual - 1) / totalNiveles) * 100);
    fill.style.width = pct + '%';
    if (label) label.textContent = pct + '% RECUPERADO';
}

function cerrarGameOver() {
    guardarTiempoMusica();
    window.location.href = 'index.php';
}

function iniciarReloj() {
    const el = document.getElementById('reloj-topbar');
    if (!el) return;
    function tick() {
        const d = new Date();
        el.textContent =
            String(d.getHours()).padStart(2,'0')   + ':' +
            String(d.getMinutes()).padStart(2,'0') + ':' +
            String(d.getSeconds()).padStart(2,'0');
    }
    tick(); setInterval(tick, 1000);
}

document.addEventListener('DOMContentLoaded', () => {
    iniciarReloj();
    iniciarMusica();

    const inp = document.getElementById('respuesta');
    if (inp) {
        setTimeout(() => inp.focus(), 300);
        inp.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                const form = inp.closest('form');
                if (form && validarFormulario()) form.submit();
            }
        });
    }
});

