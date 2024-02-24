$(document).ready(function () {
    // Establish WebSocket connection

    var globalVolume = 0.2; // Global volume, adjustable via UI
    var activeAudios = []; // Tracks all active Audio objects for volume adjustments

    var conn = new WebSocket('wss://lepetitpaco.com/ws');

    // Handle incoming messages from the WebSocket server
    conn.onmessage = function (e) {
        console.log("Received message:", e.data); // Log received message
        var message = JSON.parse(e.data);

        // Check for 'activeUsers' type message and update the UI
        if (message.type === 'activeUsers') {
            document.getElementById('activeUsers').textContent = `${message.count}`;
        }

        if (message.action === 'sound_init_sounds') {
            // Initialize the sound buttons with the received list of sound files
            var soundFiles = message.sounds;
            soundFiles.forEach(function (fileName) {
                // Remove the .mp3 extension from the fileName for the button text
                var buttonText = fileName.replace('.mp3', '').replace(/-/g, ' ').replace(/_/g, ' ').toUpperCase();
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

    // Bind the input event to #volumeSlider for real-time volume adjustments
    $('#volumeSlider').on('input', function () {
        var newVolume = $(this).val();
        updateVolume(newVolume);
    });

    $('#stopAllSounds').click(function () {
        activeAudios.forEach(function (audio) {
            audio.pause(); // Stop the audio
            audio.currentTime = 0; // Rewind to the start
        });
        activeAudios = []; // Optionally clear the array if you don't need to resume these sounds later
    });

    // COOKIES
    // Check if the volume cookie exists and set the volume
    var volumeCookie = document.cookie.split('; ').find(row => row.startsWith('volume='));
    if (volumeCookie) {
        var savedVolume = volumeCookie.split('=')[1];
        globalVolume = savedVolume;
        $('#volumeSlider').val(savedVolume);
        // Update the volume of any audio elements that might already be initialized
        activeAudios.forEach(audio => audio.volume = savedVolume);
    }

    // Check if the modal was previously closed
    if (!localStorage.getItem('audioDisclaimerSeen')) {
        // Show the modal if it hasn't been shown before
        $('#audioDisclaimerModal').modal('show');
    }

    // When the modal is closed, set a flag in localStorage
    $('#audioDisclaimerModal').on('hidden.bs.modal', function () {
        localStorage.setItem('audioDisclaimerSeen', 'true');
    });

    function updateVolume(newVolume) {
        globalVolume = newVolume;
        activeAudios.forEach(audio => audio.volume = globalVolume);

        // Save the volume setting to a cookie that expires in 7 days
        var d = new Date();
        d.setTime(d.getTime() + (7 * 24 * 60 * 60 * 1000)); // 7 days in milliseconds
        var expires = "expires=" + d.toUTCString();
        document.cookie = "volume=" + newVolume + ";" + expires + ";path=/";
    }

    // Plays a sound or sends a request to the server based on the context
    function playSound(soundFile) {
        if (typeof soundFile === 'object' && soundFile.directPlay) {
            // Direct instruction from the server to play a sound
            let audioSource = 'https://lepetitpaco.com/realtime/soundboard/sounds/' + soundFile.name;
            var audio = new Audio(audioSource);
            audio.volume = globalVolume; // Apply the current global volume
            activeAudios.push(audio); // Track this audio object
            audio.play().catch(error => console.error("Error playing sound:", error));

            // Cleanup when audio finishes playing
            audio.onended = function () {
                activeAudios = activeAudios.filter(a => a !== audio);
            };
        } else {
            // User-initiated action to play a sound; send request to the server
            var message = {
                action: 'sound_play',
                sound_file: soundFile
            };
            console.log("Sending message:", message); // Log the action
            conn.send(JSON.stringify(message)); // Send the play request to the server
        }
    }
});
