{

     // Función para reproducir el sonido
     function reproducirSonido() {
        var sonido = document.getElementById('sonido');
        sonido.play();
        
        // Remover el evento de clic para que solo se ejecute una vez
        document.removeEventListener('click', reproducirSonido);
    }

    // Añadir el evento de clic a la página
    document.addEventListener('click', reproducirSonido);
}