class Window {
    constructor(program) {
        this.program = program;
        this.isMinimized = false;
        this.isMaximized = false;
        this.element = this.createWindowElement();
        this.taskbarItem = this.createTaskbarItem();
        this.position = { x: 0, y: 0 };
        this.centerWindow();
        this.mapInstance = null;
        this.panorama = null;
        if (this.program === 'maps') {
            this.initMap();
        } else if (this.program === 'internet-explorer') {
            this.initInternetExplorer();
        }else if (this.program === 'emoji-keyboard') {
            this.initEmojiKeyboard();
        }
    }

    createWindowElement() {
        const window = document.createElement('div');
        window.className = 'window';
        window.innerHTML = `
            <div class="window-header">
                <span>${this.program}</span>
                <div class="window-controls">
                    <button class="minimize">_</button>
                    <button class="maximize">□</button>
                    <button class="close">X</button>
                </div>
            </div>
            <div class="window-content">
                ${this.getContentForProgram()}
            </div>
        `;

        this.addWindowEventListeners(window);
        return window;
    }

    getContentForProgram() {
        switch (this.program) {
            case 'maps':
                return `
                    <div id="map-container" style="width: 100%; height: 100%;">
                        <div id="map" style="width: 100%; height: 100%;"></div>
                        <button class="toggle-street-view">Toggle Street View</button>
                    </div>
                `;
            case 'emoji-keyboard':
                return `
                    <div class="emoji-keyboard">
                        <div class="emoji-categories"></div>
                        <div class="emoji-grid"></div>
                        <div class="emoji-pagination">
                            <button class="prev-page">Anterior</button>
                            <span class="page-info"></span>
                            <button class="next-page">Siguiente</button>
                        </div>
                    </div>
                `;
            case 'internet-explorer':
                return `
                    <div class="browser-container" style="width: 100%; height: 100%;">
                        <div class="browser-controls">
                            <button id="browser-back">←</button>
                            <button id="browser-forward">→</button>
                            <button id="browser-reload">↻</button>
                            <input type="text" id="browser-url" placeholder="Ingrese una URL">
                            <button id="browser-go">Ir</button>
                        </div>
                        <iframe id="browser-frame" src="https://es.wikipedia.org/wiki/Wikipedia:Portada" width="100%" height="100%" style="border: none;"></iframe>
                    </div>
                `;
            case 'notepad':
                return `<textarea class="notepad-content" style="width: 100%; height: 100%; resize: none;"></textarea>`;
            case 'my-computer':
                return `
                    <div class="file-explorer">
                        <div class="file-item">
                            <img src="images/icons/folder.png" alt="Folder">
                            <span>Documentos</span>
                        </div>
                        <div class="file-item">
                            <img src="images/icons/folder.png" alt="Folder">
                            <span>Imágenes</span>
                        </div>
                        <div class="file-item">
                            <img src="images/icons/folder.png" alt="Folder">
                            <span>Música</span>
                        </div>
                    </div>
                `;
            case 'recycle-bin':
                return `    
                    <div class="recycle-bin">
                        <p>La papelera está vacía</p>
                        <button class="empty-bin">Vaciar papelera</button>
                    </div>
                `;
            case 'minesweeper':
                return `<div id="minesweeper-game"></div>`;
            case 'solitaire':
                return `
                    <div class="solitaire-container" style="width: 100%; height: 100%;">
                        <iframe src="https://frvr.com/play/solitaire/" width="100%" height="100%" style="border: none;"></iframe>
                    </div>
                `;
            default:
                return `<p>Contenido de ${this.program}</p>`;
        }
    }

    initEmojiKeyboard() {
        this.emojiCategories = {
            'Caras': ['😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '☺️', '😚', '😙', '🥲', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐', '🤨', '😐', '😑', '😶', '😶‍🌫️', '😏', '😒', '🙄', '😬', '😮‍💨', '🤥', '😌', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '🥴', '😵', '😵‍💫', '🤯', '🤠', '🥳', '🥸', '😎', '🤓', '🧐', '😕', '😟', '🙁', '☹️', '😮', '😯', '😲', '😳', '🥺', '😦', '😧', '😨', '😰', '😥', '😢', '😭', '😱', '😖', '😣', '😞', '😓', '😩', '😫', '🥱', '😤', '😡', '😠', '🤬', '😈', '👿', '💀', '☠️', '💩', '🤡', '👹', '👺', '👻', '👽', '👾', '🤖', '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾', '🙈', '🙉', '🙊'],
            'Gestos': ['👋', '🤚', '🖐️', '✋', '🖖', '👌', '🤌', '🤏', '✌️', '🤞', '🤟', '🤘', '🤙', '👈', '👉', '👆', '🖕', '👇', '☝️', '👍', '👎', '✊', '👊', '🤛', '🤜', '👏', '🙌', '👐', '🤲', '🤝', '🙏', '✍️', '💅', '🤳', '💪', '🦾', '🦿', '🦵', '🦶', '👂', '🦻', '👃', '🧠', '🫀', '🫁', '🦷', '🦴', '👀', '👁️', '👅', '👄', '💋', '🩸'],
            'Naturaleza': ['🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐽', '🐸', '🐵', '🙈', '🙉', '🙊', '🐒', '🐔', '🐧', '🐦', '🐤', '🐣', '🐥', '🦆', '🦅', '🦉', '🦇', '🐺', '🐗', '🐴', '🦄', '🐝', '🪱', '🐛', '🦋', '🐌', '🐞', '🐜', '🪰', '🪲', '🪳', '🦟', '🦗', '🕷️', '🕸️', '🦂', '🐢', '🐍', '🦎', '🦖', '🦕', '🐙', '🦑', '🦐', '🦞', '🦀', '🐡', '🐠', '🐟', '🐬', '🐳', '🐋', '🦈', '🐊', '🐅', '🐆', '🦓', '🦍', '🦧', '🦣', '🐘', '🦛', '🦏', '🐪', '🐫', '🦒', '🦘', '🦬', '🐃', '🐂', '🐄', '🐎', '🐖', '🐏', '🐑', '🦙', '🐐', '🦌', '🐕', '🐩', '🦮', '🐕‍🦺', '🐈', '🐈‍⬛', '🪶', '🐓', '🦃', '🦤', '🦚', '🦜', '🦢', '🦩', '🕊️', '🐇', '🦝', '🦨', '🦡', '🦫', '🦦', '🦥', '🐁', '🐀', '🐿️', '🦔', '🐾', '🐉', '🐲', '🌵', '🎄', '🌲', '🌳', '🌴', '🪵', '🌱', '🌿', '☘️', '🍀', '🎍', '🪴', '🎋', '🍃', '🍂', '🍁', '🍄', '🐚', '🪨', '🌾', '💐', '🌷', '🌹', '🥀', '🌺', '🌸', '🌼', '🌻', '🌞', '🌝', '🌛', '🌜', '🌚', '🌕', '🌖', '🌗', '🌘', '🌑', '🌒', '🌓', '🌔', '🌙', '🌎', '🌍', '🌏', '🪐', '💫', '⭐', '🌟', '✨', '⚡', '☄️', '💥', '🔥', '🌪️', '🌈', '☀️', '🌤️', '⛅', '🌥️', '☁️', '🌦️', '🌧️', '⛈️', '🌩️', '🌨️', '❄️', '☃️', '⛄', '🌬️', '💨', '💧', '💦', '☔', '☂️', '🌊', '🌫️'],
            'Comida': ['🍎', '🍐', '🍊', '🍋', '🍌', '🍉', '🍇', '🍓', '🫐', '🍈', '🍒', '🍑', '🥭', '🍍', '🥥', '🥝', '🍅', '🍆', '🥑', '🥦', '🥬', '🥒', '🌶️', '🫑', '🥕', '🧄', '🧅', '🥔', '🍠', '🥐', '🥯', '🍞', '🥖', '🥨', '🧀', '🥚', '🍳', '🧈', '🥞', '🧇', '🥓', '🥩', '🍗', '🍖', '🦴', '🌭', '🍔', '🍟', '🍕', '🫓', '🥪', '🥙', '🧆', '🌮', '🌯', '🫔', '🥗', '🥘', '🫕', '🥫', '🍝', '🍜', '🍲', '🍛', '🍣', '🍱', '🥟', '🦪', '🍤', '🍙', '🍚', '🍘', '🍥', '🥠', '🥮', '🍢', '🍡', '🍧', '🍨', '🍦', '🥧', '🧁', '🍰', '🎂', '🍮', '🍭', '🍬', '🍫', '🍿', '🍩', '🍪', '🌰', '🥜', '🍯', '🥛', '🍼', '☕', '🫖', '🍵', '🧃', '🥤', '🧋', '🍶', '🍺', '🍻', '🥂', '🍷', '🥃', '🍸', '🍹', '🧉', '🍾', '🧊', '🥄', '🍴', '🍽️', '🥢', '🧂'],
            'Deportes':['⚽', '🏀', '🏈', '⚾', '🥎', '🎾', '🏐', '🏉', '🥏', '🎱', '🪀', '🏓', '🏸', '🏒', '🏑', '🥍', '🏏', '🪃', '🥅', '⛳', '🪁', '🏹', '🎣', '🤿', '🥊', '🥋', '🎽', '🛹', '🛼', '🛷', '⛸️', '🥌', '🎿', '⛷️', '🏂', '🪂', '🏋️', '🤼', '🤸', '🤺', '🤾', '🏌️', '🏇', '🧘', '🏄', '🏊', '🤽', '🚣', '🧗', '🚴', '🚵', '🎖️', '🏆', '🥇', '🥈', '🥉', '🏅', '🎗️', '🎫', '🎟️', '🎪', '🎭', '🎨', '🎬', '🎤', '🎧', '🎼', '🎹', '🥁', '🪘', '🎷', '🎺', '🪗', '🎸', '🪕', '🎻', '🎲', '♟️', '🎯', '🎳', '🎮', '🎰', '🧩'],
            'Viajes': ['🚗', '🚕', '🚙', '🚌', '🚎', '🏎️', '🚓', '🚑', '🚒', '🚐', '🛻', '🚚', '🚛', '🚜', '🦯', '🦽', '🦼', '🛴', '🚲', '🛵', '🏍️', '🛺', '🚨', '🚔', '🚍', '🚘', '🚖', '🚡', '🚠', '🚟', '🚃', '🚋', '🚞', '🚝', '🚄', '🚅', '🚈', '🚂', '🚆', '🚇', '🚊', '🚉', '✈️', '🛫', '🛬', '🛩️', '💺', '🛰️', '🚀', '🛸', '🚁', '🛶', '⛵', '🚤', '🛥️', '🛳️', '⛴️', '🚢', '⚓', '🪝', '⛽', '🚧', '🚦', '🚥', '🚏', '🗺️', '🗿', '🗽', '🗼', '🏰', '🏯', '🏟️', '🎡', '🎢', '🎠', '⛲', '⛱️', '🏖️', '🏝️', '🏜️', '🌋', '⛰️', '🏔️', '🗻', '🏕️', '⛺', '🛖', '🏠', '🏡', '🏘️', '🏚️', '🏗️', '🏭', '🏢', '🏬', '🏣', '🏤', '🏥', '🏦', '🏨', '🏪', '🏫', '🏩', '💒', '🏛️', '⛪', '🕌', '🕍', '🛕', '🕋', '⛩️', '🛤️', '🛣️', '🗾', '🎑', '🏞️', '🌅', '🌄', '🌠', '🎇', '🎆', '🌇', '🌆', '🏙️', '🌃', '🌌', '🌉', '🌁'],
            'Objetos': ['⌚', '📱', '📲', '💻', '⌨️', '🖥️', '🖨️', '🖱️', '🖲️', '🕹️', '🗜️', '💽', '💾', '💿', '📀', '📼', '📷', '📸', '📹', '🎥', '📽️', '🎞️', '📞', '☎️', '📟', '📠', '📺', '📻', '🎙️', '🎚️', '🎛️', '🧭', '⏱️', '⏲️', '⏰', '🕰️', '⌛', '⏳', '📡', '🔋', '🔌', '💡', '🔦', '🕯️', '🪔', '🧯', '🛢️', '💸', '💵', '💴', '💶', '💷', '🪙', '💰', '💳', '💎', '⚖️', '🪜', '🧰', '🪛', '🔧', '🔨', '⚒️', '🛠️', '⛏️', '🪚', '🔩', '⚙️', '🪤', '🧱', '⛓️', '🧲', '🔫', '💣', '🧨', '🪓', '🔪', '🗡️', '⚔️', '🛡️', '🚬', '⚰️', '🪦', '⚱️', '🏺', '🔮', '📿', '🧿', '💈', '⚗️', '🔭', '🔬', '🕳️', '🩹', '🩺', '💊', '💉', '🩸', '🧬', '🦠', '🧫', '🧪', '🌡️', '🧹', '🪠', '🧺', '🧻', '🚽', '🚰', '🚿', '🛁', '🛀', '🧼', '🪥', '🪒', '🧽', '🪣', '🧴', '🛎️', '🔑', '🗝️', '🚪', '🪑', '🛋️', '🛏️', '🛌', '🧸', '🖼️', '🛍️', '🛒', '🎁', '🎈', '🎏', '🎀', '🪄', '🪅', '🎊', '🎉', '🎎', '🏮', '🎐', '🧧', '✉️', '📩', '📨', '📧', '💌', '📥', '📤', '📦', '🏷️', '📪', '📫', '📬', '📭', '📮', '📯', '📜', '📃', '📄', '📑', '🧾', '📊', '📈', '📉', '🗒️', '🗓️', '📆', '📅', '🗑️', '📇', '🗃️', '🗳️', '🗄️', '📋', '📁', '📂', '🗂️', '🗞️', '📰', '📓', '📔', '📒', '📕', '📗', '📘', '📙', '📚', '📖', '🔖', '🧷', '🔗', '📎', '🖇️', '📐', '📏', '🧮', '📌', '📍', '✂️', '🖊️', '🖋️', '✒️', '🖌️', '🖍️', '📝', '✏️', '🔍', '🔎', '🔏', '🔐', '🔒', '🔓'],
            'Símbolos': ['❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '💟', '☮️', '✝️', '☪️', '🕉️', '☸️', '✡️', '🔯', '🕎', '☯️', '☦️', '🛐', '⛎', '♈', '♉', '♊', '♋', '♌', '♍', '♎', '♏', '♐', '♑', '♒', '♓', '🆔', '⚛️', '🉑', '☢️', '☣️', '📴', '📳', '🈶', '🈚', '🈸', '🈺', '🈷️', '✴️', '🆚', '💮', '🉐', '㊙️', '㊗️', '🈴', '🈵', '🈹', '🈲', '🅰️', '🅱️', '🆎', '🆑', '🅾️', '🆘', '❌', '⭕', '🛑', '⛔', '📛', '🚫', '💯', '💢', '♨️', '🚷', '🚯', '🚳', '🚱', '🔞', '📵', '🚭', '❗', '❕', '❓', '❔', '‼️', '⁉️', '🔅', '🔆', '〽️', '⚠️', '🚸', '🔱', '⚜️', '🔰', '♻️', '✅', '🈯', '💹', '❇️', '✳️', '❎', '🌐', '💠', 'Ⓜ️', '🌀', '💤', '🏧', '🚾', '♿', '🅿️', '🛗', '🈳', '🈂️', '🛂', '🛃', '🛄', '🛅', '🚹', '🚺', '🚼', '⚧️', '🚻', '🚮', '🎦', '📶', '🈁', '🔣', 'ℹ️', '🔤', '🔡', '🔠', '🆖', '🆗', '🆙', '🆒', '🆕', '🆓', '0️⃣', '1️⃣', '2️⃣', '3️⃣', '4️⃣', '5️⃣', '6️⃣', '7️⃣', '8️⃣', '9️⃣', '🔟', '🔢', '#️⃣', '*️⃣', '⏏️', '▶️', '⏸️', '⏯️', '⏹️', '⏺️', '⏭️', '⏮️', '⏩', '⏪', '⏫', '⏬', '◀️', '🔼', '🔽', '➡️', '⬅️', '⬆️', '⬇️', '↗️', '↘️', '↙️', '↖️', '↕️', '↔️', '↪️', '↩️', '⤴️', '⤵️', '🔀', '🔁', '🔂', '🔄', '🔃', '🎵', '🎶', '➕', '➖', '➗', '✖️', '♾️', '💲', '💱', '™️', '©️', '®️', '👁️‍🗨️', '🔚', '🔙', '🔛', '🔝', '🔜', '〰️', '➰', '➿', '✔️', '☑️', '🔘', '🔴', '🟠', '🟡', '🟢', '🔵', '🟣', '⚫', '⚪', '🟤', '🔺', '🔻', '🔸', '🔹', '🔶', '🔷', '🔳', '🔲', '▪️', '▫️', '◾', '◽', '◼️', '◻️', '🟥', '🟧', '🟨', '🟩', '🟦', '🟪', '⬛', '⬜', '🟫', '🔈', '🔇', '🔉', '🔊', '🔔', '🔕', '📣', '📢'],

            // ... Puedes añadir más categorías aquí
        };
        this.currentCategory = Object.keys(this.emojiCategories)[0];
        this.currentPage = 1;
        this.emojisPerPage = 48;

        const categoryContainer = this.element.querySelector('.emoji-categories');
        Object.keys(this.emojiCategories).forEach(category => {
            const button = document.createElement('button');
            button.textContent = category;
            button.addEventListener('click', () => this.changeCategory(category));
            categoryContainer.appendChild(button);
        });

        const prevButton = this.element.querySelector('.prev-page');
        const nextButton = this.element.querySelector('.next-page');
        prevButton.addEventListener('click', () => this.changePage(-1));
        nextButton.addEventListener('click', () => this.changePage(1));

        this.updateEmojiGrid();
        // Agregar evento de redimensionamiento
        window.addEventListener('resize', () => {
            this.updateEmojiGrid();
        });
    }

    changeCategory(category) {
        this.currentCategory = category;
        this.currentPage = 1;
        this.updateEmojiGrid();
    }

    changePage(delta) {
        const totalPages = Math.ceil(this.emojiCategories[this.currentCategory].length / this.emojisPerPage);
        this.currentPage = Math.max(1, Math.min(this.currentPage + delta, totalPages));
        this.updateEmojiGrid();
    }

    updateEmojiGrid() {
        const emojiGrid = this.element.querySelector('.emoji-grid');
        emojiGrid.innerHTML = '';
        // Calcular el número de emojis que caben en la pantalla
        const gridRect = emojiGrid.getBoundingClientRect();
        const buttonSize = 40; // Tamaño aproximado de cada botón de emoji
        const columns = Math.floor(gridRect.width / buttonSize);
        const rows = Math.floor(gridRect.height / buttonSize);
        this.emojisPerPage = columns * rows;

        const startIndex = (this.currentPage - 1) * this.emojisPerPage;
        const endIndex = startIndex + this.emojisPerPage;
        const emojisToShow = this.emojiCategories[this.currentCategory].slice(startIndex, endIndex);

        emojisToShow.forEach(emoji => {
            const button = document.createElement('button');
            button.textContent = emoji;
            button.addEventListener('click', () => this.insertEmoji(emoji));
            emojiGrid.appendChild(button);
        });

        const pageInfo = this.element.querySelector('.page-info');
        const totalPages = Math.ceil(this.emojiCategories[this.currentCategory].length / this.emojisPerPage);
        pageInfo.textContent = `Página ${this.currentPage} de ${totalPages}`;
    }

    insertEmoji(emoji) {
        const notepadWindow = Array.from(document.querySelectorAll('.window'))
            .find(w => w.querySelector('.window-header span').textContent === 'notepad');
        
        if (notepadWindow) {
            const textarea = notepadWindow.querySelector('.notepad-content');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;
            const before = text.substring(0, start);
            const after = text.substring(end);
            textarea.value = before + emoji + after;
            textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
            textarea.focus();
        } else {
            alert('Por favor, abre el Notepad primero para usar el teclado de emojis.');
        }
    }

    initInternetExplorer() {
        const container = this.element.querySelector('.browser-container');
        const iframe = container.querySelector('#browser-frame');
        const backBtn = container.querySelector('#browser-back');
        const forwardBtn = container.querySelector('#browser-forward');
        const reloadBtn = container.querySelector('#browser-reload');
        const urlInput = container.querySelector('#browser-url');
        const goBtn = container.querySelector('#browser-go');

        backBtn.addEventListener('click', () => iframe.contentWindow.history.back());
        forwardBtn.addEventListener('click', () => iframe.contentWindow.history.forward());
        reloadBtn.addEventListener('click', () => iframe.contentWindow.location.reload());

        goBtn.addEventListener('click', () => {
            let url = urlInput.value.trim();
            if (!url.startsWith('http://') && !url.startsWith('https://')) {
                url = 'https://' + url;
            }
            iframe.src = url;
        });

        urlInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                goBtn.click();
            }
        });

        // Ajustar el estilo para los controles del navegador
        const style = document.createElement('style');
        style.textContent = `
            .browser-controls {
                display: flex;
                padding: 5px;
                background-color: #f0f0f0;
            }
            .browser-controls button {
                margin-right: 5px;
            }
            .browser-controls input {
                flex-grow: 1;
                margin-right: 5px;
            }
        `;
        document.head.appendChild(style);
    }

        initMap() {
            if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                if (!window.mapsCallbacks) {
                    window.mapsCallbacks = [];
                }
    
                window.mapsCallbacks.push(() => this.setupMap());
    
                if (!document.querySelector('script[src*="maps.googleapis.com/maps/api/js"]')) {
                    const script = document.createElement('script');
                    script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyAPLgcdubhw7rDS9u-BeHPuoI8mg6ri5S8&callback=initMap`;
                    script.async = true;
                    script.defer = true;
                    document.head.appendChild(script);
    
                    window.initMap = () => this.setupMap();
                }
            } else {
                this.setupMap();
            }
        }

        setupMap() {
            const mapDiv = this.element.querySelector('#map');
            if (!mapDiv) {
                console.error('Map container not found');
                return;
            }
    
            try {
                this.mapInstance = new google.maps.Map(mapDiv, {
                    center: { lat: 37.3943436, lng: -5.9304048 },
                    zoom: 14
                });
    
                google.maps.event.addListenerOnce(this.mapInstance, 'idle', () => {
                    this.panorama = this.mapInstance.getStreetView();
                    const toggleButton = this.element.querySelector('.toggle-street-view');
                    if (toggleButton) {
                        toggleButton.addEventListener('click', () => this.toggleStreetView());
                    }
                });
            } catch (error) {
                console.error('Error setting up map:', error);
            }
        }
    
        toggleStreetView() {
            if (!this.panorama) {
                console.error('Street View not initialized');
                return;
            }
            
            const toggle = this.panorama.getVisible();
            if (toggle == false) {
                this.panorama.setPosition(this.mapInstance.getCenter());
                this.panorama.setPov({
                    heading: 34,
                    pitch: 10
                });
                this.panorama.setVisible(true);
            } else {
                this.panorama.setVisible(false);
            }
        }
    

    createTaskbarItem() {
        const item = document.createElement('div');
        item.className = 'taskbar-item';
        item.textContent = this.program;
        item.addEventListener('click', () => this.toggleMinimize());
        return item;
    }

    addWindowEventListeners(window) {
        const controls = window.querySelector('.window-controls');
        controls.querySelector('.minimize').addEventListener('click', () => this.minimize());
        controls.querySelector('.maximize').addEventListener('click', () => this.toggleMaximize());
        controls.querySelector('.close').addEventListener('click', () => this.close());

        this.makeDraggable(window);

        // Agregar listeners específicos para cada programa
        if (this.program === 'recycle-bin') {
            const emptyButton = window.querySelector('.empty-bin');
            emptyButton.addEventListener('click', () => {
                alert('La papelera ha sido vaciada');
            });
        } else if (this.program === 'minesweeper') {
            // Inicializar el juego del buscaminas
            initMinesweeper(window.querySelector('#minesweeper-game'));
        }
    }
    initSolitaire() {
        const container = this.element.querySelector('.solitaire-container');
        const iframe = container.querySelector('iframe');

        // Ajustar el tamaño del iframe cuando la ventana cambie de tamaño
        const resizeObserver = new ResizeObserver(() => {
            this.adjustIframeSize(iframe);
        });
        resizeObserver.observe(container);
    }


    centerWindow() {
        const desktop = document.getElementById('desktop');
        const rect = desktop.getBoundingClientRect();
        this.position.x = (rect.width - this.element.offsetWidth) / 2;
        this.position.y = (rect.height - this.element.offsetHeight) / 2;
        this.updatePosition();
    }

    updatePosition() {
        this.element.style.left = `${this.position.x}px`;
        this.element.style.top = `${this.position.y}px`;
    }

    makeDraggable(window) {
        const header = window.querySelector('.window-header');
        header.addEventListener('mousedown', (e) => {
            if (this.isMaximized) return;

            const startX = e.clientX - this.position.x;
            const startY = e.clientY - this.position.y;

            const onMouseMove = (e) => {
                this.position.x = e.clientX - startX;
                this.position.y = e.clientY - startY;
                this.updatePosition();
            };

            const onMouseUp = () => {
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            };

            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });
    }

    minimize() {
        this.isMinimized = true;
        this.element.style.display = 'none';
        this.taskbarItem.classList.add('minimized');
    }

    toggleMinimize() {
        if (this.isMinimized) {
            this.isMinimized = false;
            this.element.style.display = 'block';
            this.taskbarItem.classList.remove('minimized');
        } else {
            this.minimize();
        }
    }

    toggleMaximize() {
        this.isMaximized = !this.isMaximized;
        this.element.classList.toggle('maximized');
        if (!this.isMaximized) {
            this.updatePosition();
        }
        this.adjustIframeSize();
    }

    adjustIframeSize() {
        const iframe = this.element.querySelector('iframe');
        if (iframe) {
            if (this.isMaximized) {
                const desktopRect = document.getElementById('desktop').getBoundingClientRect();
                iframe.style.width = `${desktopRect.width}px`;
                iframe.style.height = `${desktopRect.height - 30}px`; // 30px for the window header
            } else {
                iframe.style.width = '100%';
                iframe.style.height = '100%';
            }
        }
    }

    close() {
        if (this.mapInstance) {
            // Clean up the map instance
            google.maps.event.clearInstanceListeners(this.mapInstance);
            this.mapInstance = null;
        }
        this.element.remove();
        this.taskbarItem.remove();
    }
}

function openWindow(program) {
    const window = new Window(program);
    const container = document.getElementById('windows-container');
    container.appendChild(window.element);
    window.element.windowInstance = window;  // Store a reference to the Window instance
    document.getElementById('taskbar-programs').appendChild(window.taskbarItem);
}

// Event listener for desktop icons
document.querySelectorAll('.desktop-icon').forEach(icon => {
    icon.addEventListener('click', () => {
        const program = icon.getAttribute('data-program');
        openWindow(program);
    });
});