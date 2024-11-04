<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hundir la Flota</title>
    <style>
        .game-board {
            border-collapse: collapse;
            margin: 20px auto;
        }
        
        .game-board td, .game-board th {
            width: 40px;
            height: 40px;
            border: 1px solid #999;
            text-align: center;
        }
        
        .water {
            background-color: #e3f2fd;
        }
        
        .hit {
            background-color: #f44336;
        }
        
        .miss {
            background-color: #90a4ae;
        }
        
        .game-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        
        .input-form {
            margin: 20px 0;
        }
        
        .message {
            margin: 20px 0;
            padding: 10px;
            border-radius: 4px;
        }
        
        .success {
            background-color: #c8e6c9;
            color: #2e7d32;
        }
        
        .error {
            background-color: #ffcdd2;
            color: #c62828;
        }
    </style>
</head>
<body>
    <div class="game-container">
        <h1>Hundir la Flota</h1>
        
        <?php
        include_once('battleship.php');
        $game = null;
        $message = '';
        $messageClass = '';
        
        // Procesar nueva partida
        if (isset($_POST['new_game'])) {
            $game = new Battleship();
        } 
        // Cargar partida existente
        else if (isset($_POST['game_state'])) {
            $game = new Battleship($_POST['game_state']);
            
            // Procesar disparo
            if (isset($_POST['row']) && isset($_POST['col'])) {
                $row = ord(strtoupper($_POST['row'])) - 65;
                $col = intval($_POST['col']) - 1;
                
                $result = $game->makeShot($row, $col);
                
                if (!$result['valid']) {
                    $message = $result['message'];
                    $messageClass = 'error';
                } else if ($result['hit']) {
                    if (isset($result['sunk']) && $result['sunk']) {
                        $message = '¡Has hundido un ' . $result['shipName'] . '!';
                    } else {
                        $message = '¡Has alcanzado un ' . $result['shipName'] . '!';
                    }
                    $messageClass = 'success';
                } else {
                    $message = '¡Agua!';
                    $messageClass = 'error';
                }
                
                if ($game->isGameOver()) {
                    $message = '¡Felicitaciones! ¡Has ganado el juego!';
                    $messageClass = 'success';
                }
            }
        } 
        // Primera carga
        else {
            $game = new Battleship();
        }
        
        // Mostrar mensaje si existe
        if ($message) {
            echo '<div class="message ' . $messageClass . '">' . $message . '</div>';
        }
        
        // Renderizar tablero
        echo $game->renderBoard();
        
        // Formulario de disparo
        if (!$game->isGameOver()) {
            ?>
            <form class="input-form" method="post">
                <input type="hidden" name="game_state" value="<?php echo htmlspecialchars($game->getState()); ?>">
                <label>
                    Fila (A-J):
                    <input type="text" name="row" maxlength="1" pattern="[A-Ja-j]" required>
                </label>
                <label>
                    Columna (1-10):
                    <input type="number" name="col" min="1" max="10" required>
                </label>
                <button type="submit">¡Disparar!</button>
            </form>
            <?php
        } else {
            ?>
            <form method="post">
                <input type="hidden" name="new_game" value="1">
                <button type="submit">Nueva partida</button>
            </form>
            <?php
        }
        ?>
    </div>
</body>
</html>