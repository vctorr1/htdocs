<?php
class Battleship {
    private $boardSize = 10;
    private $ships = [
        'portaaviones' => ['size' => 5, 'name' => 'Portaaviones'],
        'acorazado' => ['size' => 4, 'name' => 'Acorazado'],
        'submarino1' => ['size' => 3, 'name' => 'Submarino'],
        'submarino2' => ['size' => 3, 'name' => 'Submarino'],
        'destructor' => ['size' => 2, 'name' => 'Destructor']
    ];
    private $board = [];
    private $shots = [];
    private $gameState = [];
    
    public function __construct($existingState = null) {
        if ($existingState) {
            $this->loadState($existingState);
        } else {
            $this->initializeBoard();
            $this->placeShips();
        }
    }
    
    private function initializeBoard() {
        for ($i = 0; $i < $this->boardSize; $i++) {
            for ($j = 0; $j < $this->boardSize; $j++) {
                $this->board[$i][$j] = 0; // 0 = agua
            }
        }
        $this->shots = array_fill(0, $this->boardSize, array_fill(0, $this->boardSize, false));
    }
    
    private function placeShips() {
        foreach ($this->ships as $shipId => $shipData) {
            $placed = false;
            while (!$placed) {
                $direction = rand(0, 1); // 0 = horizontal, 1 = vertical
                $row = rand(0, $this->boardSize - 1);
                $col = rand(0, $this->boardSize - 1);
                
                if ($this->canPlaceShip($row, $col, $shipData['size'], $direction)) {
                    $this->placeShip($row, $col, $shipData['size'], $direction, $shipId);
                    $placed = true;
                }
            }
        }
    }
    
    private function canPlaceShip($row, $col, $size, $direction) {
        // Verificar límites del tablero
        if ($direction == 0) { // horizontal
            if ($col + $size > $this->boardSize) return false;
        } else { // vertical
            if ($row + $size > $this->boardSize) return false;
        }
        
        // Verificar colisiones con otros barcos
        for ($i = 0; $i < $size; $i++) {
            $checkRow = $direction == 1 ? $row + $i : $row;
            $checkCol = $direction == 0 ? $col + $i : $col;
            
            // Verificar casilla actual y adyacentes
            for ($r = -1; $r <= 1; $r++) {
                for ($c = -1; $c <= 1; $c++) {
                    $adjRow = $checkRow + $r;
                    $adjCol = $checkCol + $c;
                    
                    if ($adjRow >= 0 && $adjRow < $this->boardSize &&
                        $adjCol >= 0 && $adjCol < $this->boardSize &&
                        $this->board[$adjRow][$adjCol] !== 0) {
                        return false;
                    }
                }
            }
        }
        
        return true;
    }
    
    private function placeShip($row, $col, $size, $direction, $shipId) {
        for ($i = 0; $i < $size; $i++) {
            if ($direction == 0) { // horizontal
                $this->board[$row][$col + $i] = $shipId;
            } else { // vertical
                $this->board[$row + $i][$col] = $shipId;
            }
        }
    }
    
    public function makeShot($row, $col) {
        if ($row < 0 || $row >= $this->boardSize || 
            $col < 0 || $col >= $this->boardSize) {
            return ['valid' => false, 'message' => 'Coordenadas fuera del tablero'];
        }
        
        if ($this->shots[$row][$col]) {
            return ['valid' => false, 'message' => 'Ya has disparado en esta posición'];
        }
        
        $this->shots[$row][$col] = true;
        
        if ($this->board[$row][$col] !== 0) {
            $shipId = $this->board[$row][$col];
            $shipName = $this->ships[$shipId]['name'];
            
            if ($this->isShipSunk($shipId)) {
                return [
                    'valid' => true,
                    'hit' => true,
                    'sunk' => true,
                    'shipName' => $shipName
                ];
            }
            return [
                'valid' => true,
                'hit' => true,
                'sunk' => false,
                'shipName' => $shipName
            ];
        }
        
        return ['valid' => true, 'hit' => false];
    }
    
    private function isShipSunk($shipId) {
        for ($i = 0; $i < $this->boardSize; $i++) {
            for ($j = 0; $j < $this->boardSize; $j++) {
                if ($this->board[$i][$j] === $shipId && !$this->shots[$i][$j]) {
                    return false;
                }
            }
        }
        return true;
    }
    
    public function isGameOver() {
        foreach ($this->ships as $shipId => $shipData) {
            if (!$this->isShipSunk($shipId)) {
                return false;
            }
        }
        return true;
    }
    
    public function getState() {
        return serialize([
            'board' => $this->board,
            'shots' => $this->shots,
            'ships' => $this->ships
        ]);
    }
    
    private function loadState($state) {
        $data = unserialize($state);
        $this->board = $data['board'];
        $this->shots = $data['shots'];
        $this->ships = $data['ships'];
    }
    
    public function renderBoard() {
        $html = '<table class="game-board">';
        // Cabecera con números
        $html .= '<tr><th></th>';
        for ($i = 0; $i < $this->boardSize; $i++) {
            $html .= '<th>' . ($i + 1) . '</th>';
        }
        $html .= '</tr>';
        
        // Filas del tablero
        for ($i = 0; $i < $this->boardSize; $i++) {
            $html .= '<tr>';
            // Letra de la fila
            $html .= '<th>' . chr(65 + $i) . '</th>';
            
            for ($j = 0; $j < $this->boardSize; $j++) {
                $class = 'water';
                if ($this->shots[$i][$j]) {
                    if ($this->board[$i][$j] !== 0) {
                        $class = 'hit';
                    } else {
                        $class = 'miss';
                    }
                }
                $html .= '<td class="' . $class . '"></td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }
}