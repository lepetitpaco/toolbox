$(document).ready(function () {

    // Establish WebSocket connection
    var conn;

    function connectWebSocket() {
        conn = new WebSocket('wss://lepetitpaco.com/ws');

        conn.onopen = function (e) {
            // console.log("Connection established!");

            // Fetch initial word data
            fetchWordData();

            // Event handler for adding a word
            $('#add-word-btn').click(function () {
                const word = prompt("Entrez le mot que vous voulez ajouter:");
                if (word) {
                    if (confirm(`Es-tu sûr de vouloir ajouter le mot "${word}"?`)) {
                        if (confirm("Es-tu vraiment, vraiment sûr?")) {
                            if (confirm("Sérieusement, tu veux absolument faire ça?")) {
                                if (confirm(`Est-ce que tu veux réellement ajouter ce mot "${word}"?`)) {
                                    modifyWord('add', { word });
                                }
                            }
                        }
                    }
                }
            });

            // Event delegation for remove, increment, decrement, and rename buttons
            $('#word-list').on('click', '.remove-btn', function () {
                const word = $(this).data('word');
                if (confirm(`Es-tu sûr de vouloir supprimer le mot "${word}"?`)) {
                    if (confirm("Es-tu vraiment, vraiment sûr?")) {
                        if (confirm("Sérieusement, tu veux absolument faire ça?")) {
                            if (confirm(`Est-ce que tu veux réellement supprimer ce mot "${word}"?`)) {
                                modifyWord('remove', { word });
                            }
                        }
                    }
                }
            }).on('click', '.increment-btn', function () {
                const word = $(this).data('word');
                if (confirm(`Es-tu sûr de vouloir incrémenter le nombre de "${word}"?`)) {
                    modifyWord('increment', { word });
                }
            }).on('click', '.decrement-btn', function () {
                const word = $(this).data('word');
                if (confirm(`Es-tu sûr de vouloir décrémenter le nombre de "${word}"?`)) {
                    modifyWord('decrement', { word });
                }
            }).on('click', '.rename-btn', function () {
                const oldWord = $(this).data('word');
                const newWord = prompt("Entrez le nouveau mot:");
                if (newWord) {
                    if (confirm(`Es-tu sûr de vouloir renommer "${oldWord}" en "${newWord}"?`)) {
                        if (confirm("Es-tu vraiment, vraiment sûr?")) {
                            if (confirm("Sérieusement, tu veux absolument faire ça?")) {
                                if (confirm(`Est-ce que tu veux réellement renommer "${oldWord}" en "${newWord}"?`)) {
                                    modifyWord('rename', { oldWord, newWord });
                                }
                            }
                        }
                    }
                }
            });

        };


        conn.onmessage = function (e) {
            try {
                var message = JSON.parse(e.data);
                if (message.data.type == 'update') {
                    // Update the DOM directly with the received data
                    fetchWordData(); // Assuming message.data contains the updated word data
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

    // Fetch word data from the server
    function fetchWordData() {
        $.ajax({
            url: 'ajax.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                updateWordList(data);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching word data:', error);
            }
        });
    }

    // Update word list display
    function updateWordList(wordData) {
        // console.log('wordata', wordData);
        const wordListContainer = $('#word-list');
        wordListContainer.empty(); // Clear previous list

        $.each(wordData, function (index, item) {
            // Create HTML elements for each word item
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
        var requestData = { action: action };
        if (action == 'rename') {
            requestData.oldWord = data.oldWord;
            requestData.newWord = data.newWord;
        } else {
            requestData.word = data.word;
        }

        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: requestData,
            success: function (response) {
                conn.send(JSON.stringify(response)); // Notify WebSocket server with the same action and data
            },
            error: function (xhr, status, error) {
                console.error('Error modifying word data:', error);
            }
        });
    }





});
