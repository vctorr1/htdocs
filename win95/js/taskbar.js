// Función para alternar el menú de inicio
function toggleStartMenu() {
    const startMenu = document.getElementById('startMenu');
    startMenu.style.display = startMenu.style.display === 'block' ? 'none' : 'block';
}

// Actualiza la barra de tareas al abrir o cerrar ventanas
function updateTaskbar(windowName, action) {
    const taskButton = document.getElementById(windowName + 'Task');
    if (action === 'open') {
        taskButton.classList.remove('hidden');
    } else if (action === 'close') {
        taskButton.classList.add('hidden');
    }
}

// Función para manejar la apertura de la ventana en la barra de tareas
function openTaskButton(windowName) {
    const taskButton = document.getElementById(windowName + 'Task');
    taskButton.classList.remove('hidden');
}

// Función para actualizar la hora en la barra de tareas
function updateTime() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const timeString = `${hours}:${minutes}`;
    
    const timeElement = document.getElementById('taskbarTime');
    if (timeElement) {
        timeElement.textContent = timeString;
    }
}

// Actualizar la hora cada minuto
setInterval(updateTime, 60000);

// Inicializar la hora al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    updateTime();
});