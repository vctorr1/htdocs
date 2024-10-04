// Menú contextual
function createContextMenu() {
    const menu = document.createElement('div');
    menu.id = 'context-menu';
    menu.className = 'context-menu';
    menu.innerHTML = `
        <div class="menu-item">Ver</div>
        <div class="menu-item">Ordenar por</div>
        <div class="menu-item">Actualizar</div>
        <hr>
        <div class="menu-item">Pegar</div>
        <div class="menu-item">Pegar acceso directo</div>
        <div class="menu-item">Nuevo</div>
        <hr>
        <div class="menu-item">Propiedades</div>
    `;
    document.body.appendChild(menu);
    return menu;
}

function showContextMenu(e) {
    e.preventDefault();
    const menu = document.getElementById('context-menu') || createContextMenu();
    menu.style.display = 'block';
    menu.style.left = `${e.clientX}px`;
    menu.style.top = `${e.clientY}px`;

    document.addEventListener('click', hideContextMenu);
}

function hideContextMenu() {
    const menu = document.getElementById('context-menu');
    if (menu) {
        menu.style.display = 'none';
    }
    document.removeEventListener('click', hideContextMenu);
}

// Menú de inicio
function createStartMenu() {
    const menu = document.createElement('div');
    menu.id = 'start-menu';
    menu.className = 'start-menu';
    menu.innerHTML = `
        <div class="start-menu-header">
            <img src="images/start_button.png" alt="Windows 95">
            <span>Windows 95</span>
        </div>
        <div class="start-menu-item">Programas</div>
        <div class="start-menu-item">Documentos</div>
        <div class="start-menu-item">Configuración</div>
        <div class="start-menu-item">Buscar</div>
        <div class="start-menu-item">Ayuda</div>
        <div class="start-menu-item">Ejecutar</div>
        <hr>
        <div class="start-menu-item">Apagar el sistema...</div>
    `;
    document.body.appendChild(menu);
    return menu;
}

function toggleStartMenu() {
    const menu = document.getElementById('start-menu') || createStartMenu();
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

// Event listeners
document.getElementById('desktop').addEventListener('contextmenu', showContextMenu);
document.getElementById('start-button').addEventListener('click', toggleStartMenu);

// Cerrar el menú de inicio al hacer clic fuera de él
document.addEventListener('click', (e) => {
    if (!e.target.closest('#start-menu') && !e.target.closest('#start-button')) {
        const startMenu = document.getElementById('start-menu');
        if (startMenu) {
            startMenu.style.display = 'none';
        }
    }
});