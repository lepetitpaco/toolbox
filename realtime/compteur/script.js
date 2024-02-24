$(document).ready(function () {

    // Establish WebSocket connection
    var conn;

    function connectWebSocket() {
        conn = new WebSocket('wss://lepetitpaco.com/ws');

        conn.onopen = function (e) {
            // Fetch initial word data
            conn.send(JSON.stringify({ action: 'word_fetchInitialData' }));

            // Event handler for adding a word
            $('#add-word-btn').click(function () {
                const word = prompt("Entrez le mot que vous voulez ajouter:");
                if (word && confirm(`Es-tu sûr de vouloir ajouter le mot "${word}"?`)) {
                    modifyWord('add', { word });
                }
            });

            // Event delegation for remove, increment, decrement, and rename buttons
            $('#word-list').on('click', '.remove-btn', function () {
                const word = $(this).data('word');
                if (confirm(`Es-tu sûr de vouloir supprimer le mot "${word}"?`)) {
                    modifyWord('remove', { word });
                }
            }).on('click', '.increment-btn', function () {
                const word = $(this).data('word');
                modifyWord('increment', { word }); // No confirmation for increment
            }).on('click', '.decrement-btn', function () {
                const word = $(this).data('word');
                modifyWord('decrement', { word }); // No confirmation for decrement
            }).on('click', '.rename-btn', function () {
                const word = $(this).data('word');
                const newWord = prompt("Entrez le nouveau mot:");
                if (newWord && confirm(`Es-tu sûr de vouloir renommer "${word}" en "${newWord}"?`)) {
                    modifyWord('rename', { word, newWord });
                }
            });
        };


        conn.onmessage = function (e) {
            try {
                var message = JSON.parse(e.data);
                // console.log("Received message:", message);
                // Handle initial data load and updates differently if needed
                if (message.type === 'initialData') {
                    updateWordList(message.data); // Assuming the server sends the initial data structured this way
                } else if (message.type === 'update') {
                    // Handle real-time updates here, e.g., refresh the word list or update a specific word
                    updateWordList(message.data); // Use the same function if the format is consistent
                }
            } catch (error) {
                console.error("Error parsing JSON:", error);
            }
        };

        conn.onerror = function (error) {
            console.error("WebSocket Error: ", error);
            // Optionally implement reconnection logic or notify the user
            setTimeout(connectWebSocket, 5000); // Reconnect after 5 seconds
        };
    }

    connectWebSocket(); // Connect WebSocket initially

    // Update word list display
    function updateWordList(wordData) {
        const wordListContainer = $('#word-list');
        wordListContainer.empty(); // Clear previous list

        $.each(wordData, function (index, item) {
            const wordItem = $(`
                <div class="word-item d-flex justify-content-between align-items-center bg-light p-3 rounded">
                    <span>${item.word}: <strong>${item.count}</strong></span>
                    <div>
                        <button class="increment-btn btn btn-success me-2" data-word="${item.word}">+</button>
                        <button class="decrement-btn btn btn-warning me-2" data-word="${item.word}">-</button>
                        <button class="rename-btn btn btn-info me-2" data-word="${item.word}">Rename</button>
                        <button class="remove-btn btn btn-danger me-2" data-word="${item.word}">Remove</button>
                    </div>
                </div>
            `);
            // Append the word item to the word list container
            wordListContainer.append(wordItem);
        });
    }

    function modifyWord(action, data) {


        // Create a message object to send to the WebSocket server
        var message = {
            action: 'word_' + action,
            word: data.word, // This will be ignored for the rename action, handled below
            newWord: data.newWord  // Included for rename action
        };

        // Send the message as a string to the WebSocket server
        conn.send(JSON.stringify(message));
    }
});
