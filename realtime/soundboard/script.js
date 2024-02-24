$(document).ready(function () {
    // Establish WebSocket connection
    var conn = new WebSocket('wss://lepetitpaco.com/ws');

    // Function to play a sound based on the sound file name
    function playSound(soundFile) {
        // Check if this function is called as a result of a button click
        // or as a direct instruction from the server
        if (typeof soundFile === 'object' && soundFile.directPlay) {
            // Directly play the sound without sending a message
            var audio = new Audio('https://lepetitpaco.com/realtime/soundboard/sounds/' + soundFile.name);
            audio.play().catch(error => console.error("Error playing sound:", error));
        } else {
            // Send a message to the server to play this sound
            var message = {
                action: 'sound_play',
                sound_file: soundFile
            };

            console.log("Sending message:", message); // Log sending message
            conn.send(JSON.stringify(message));
        }
    }

    // Handle incoming messages from the WebSocket server
    conn.onmessage = function (e) {
        console.log("Received message:", e.data); // Log received message
        var message = JSON.parse(e.data);

        if (message.action === 'sound_init_sounds') {
            // Initialize the sound buttons with the received list of sound files
            var soundFiles = message.sounds;
            soundFiles.forEach(function (fileName) {
                // Remove the .mp3 extension from the fileName for the button text
                var buttonText = fileName.replace('.mp3', '').replace(/-/g, ' ').toUpperCase();
                var soundButton = $('<button class="btn sound-btn">' + buttonText + '</button>');
                soundButton.click(function () {
                    playSound(fileName);
                });
                $('#sound-buttons').append(soundButton);
            });
        } else if (message.action === 'sound_play') {
            // Directly play the sound received from the server without sending it back
            playSound({ name: message.sound_file, directPlay: true });
        }
    };

    // Handle errors
    conn.onerror = function (error) {
        console.error("WebSocket Error: ", error);
    };
});
