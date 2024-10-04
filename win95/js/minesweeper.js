function initMinesweeper(container) {
    const ROWS = 9;
    const COLS = 9;
    const MINES = 10;
    let board = [];
    let revealed = [];

    function createBoard() {
        // Inicializar el tablero
        for (let i = 0; i < ROWS; i++) {
            board[i] = new Array(COLS).fill(0);
            revealed[i] = new Array(COLS).fill(false);
        }

        // Colocar minas aleatoriamente
        let minesPlaced = 0;
        while (minesPlaced < MINES) {
            const row = Math.floor(Math.random() * ROWS);
            const col = Math.floor(Math.random() * COLS);
            if (board[row][col] !== -1) {
                board[row][col] = -1;
                minesPlaced++;
            }
        }

        // Calcular números para las celdas adyacentes a las minas
        for (let i = 0; i < ROWS; i++) {
            for (let j = 0; j < COLS; j++) {
                if (board[i][j] === -1) continue;
                board[i][j] = countAdjacentMines(i, j);
            }
        }
    }

    function countAdjacentMines(row, col) {
        let count = 0;
        for (let i = -1; i <= 1; i++) {
            for (let j = -1; j <= 1; j++) {
                const newRow = row + i;
                const newCol = col + j;
                if (newRow >= 0 && newRow < ROWS && newCol >= 0 && newCol < COLS) {
                    if (board[newRow][newCol] === -1) count++;
                }
            }
        }
        return count;
    }

    function revealCell(row, col) {
        if (row < 0 || row >= ROWS || col < 0 || col >= COLS || revealed[row][col]) return;

        revealed[row][col] = true;
        const cell = document.querySelector(`.minesweeper-cell[data-row="${row}"][data-col="${col}"]`);
        
        if (board[row][col] === -1) {
            cell.textContent = '💣';
            alert('¡Has perdido!');
            revealAllMines();
        } else if (board[row][col] === 0) {
            cell.textContent = '';
            // Revelar celdas adyacentes
            for (let i = -1; i <= 1; i++) {
                for (let j = -1; j <= 1; j++) {
                    revealCell(row + i, col + j);
                }
            }
        } else {
            cell.textContent = board[row][col];
        }

        checkWin();
    }

    function revealAllMines() {
        for (let i = 0; i < ROWS; i++) {
            for (let j = 0; j < COLS; j++) {
                if (board[i][j] === -1) {
                    const cell = document.querySelector(`.minesweeper-cell[data-row="${i}"][data-col="${j}"]`);
                    cell.textContent = '💣';
                }
            }
        }
    }

    function checkWin() {
        let revealedCount = 0;
        for (let i = 0; i < ROWS; i++) {
            for (let j = 0; j < COLS; j++) {
                if (revealed[i][j]) revealedCount++;
            }
        }
        if (revealedCount === ROWS * COLS - MINES) {
            alert('¡Has ganado!');
        }
    }

    function renderBoard() {
        container.innerHTML = '';
        const boardElement = document.createElement('div');
        boardElement.className = 'minesweeper-board';
        
        for (let i = 0; i < ROWS; i++) {
            for (let j = 0; j < COLS; j++) {
                const cell = document.createElement('div');
                cell.className = 'minesweeper-cell';
                cell.dataset.row = i;
                cell.dataset.col = j;
                cell.addEventListener('click', () => revealCell(i, j));
                boardElement.appendChild(cell);
            }
        }
        
        container.appendChild(boardElement);
    }

    createBoard();
    renderBoard();
}