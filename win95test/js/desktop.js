// desktop.js

document.addEventListener('DOMContentLoaded', () => {
    const desktop = document.getElementById('desktop');

    // Menú contextual del escritorio (clic derecho)
    desktop.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        const menu = document.getElementById('desktopContextMenu');
        menu.style.top = `${e.clientY}px`;
        menu.style.left = `${e.clientX}px`;
        menu.style.display = 'block';
    });

    document.addEventListener('click', function() {
        document.getElementById('desktopContextMenu').style.display = 'none';
    });
});

// Función para refrescar el escritorio
function refreshDesktop() {
    alert('Actualizando escritorio...');
}

// Función para abrir una ventana
function openWindow(windowName) {
    const window = document.getElementById(windowName + 'Window');
    window.classList.remove('hidden');
    document.getElementById(windowName + 'Task').classList.remove('hidden');
}
