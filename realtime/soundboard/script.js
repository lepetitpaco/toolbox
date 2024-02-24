$(document).ready(function () {
    // Establish WebSocket connection

    var globalVolume = 0.2; // Global volume, adjustable via UI
    var activeAudios = []; // Tracks all active Audio objects for volume adjustments

    // By adding a parameter service, we can verify in the server that it is a connection from the soundboard and only displaying the number of soundboard users
    var conn = new WebSocket('wss://lepetitpaco.com/ws?service=soundboard');

    // Handle incoming messages from the WebSocket server
    conn.onmessage = function (e) {
        console.log("Received message:", e.data); // Log received message
        var message = JSON.parse(e.data);

        // Check for 'activeUsers' type message and update the UI
        if (message.type === 'activeUsers') {
            document.getElementById('activeUsers').textContent = `${message.count}`;
        }

        if (message.action === 'sound_init_sounds') {
            buildSoundboard(message.sounds);
        } else if (message.action === 'sound_play') {
            // Directly play the sound received from the server without sending it back
            playSound({ name: message.sound_file, directPlay: true });
        }
    };

    // Function to parse URL parameters
    function getUrlParams() {
        const params = {};
        const queryString = window.location.search.substring(1);
        queryString.split('&').forEach((param) => {
            let [key, value] = param.split('=');
            params[key] = value;
        });
        return params;
    }

    // Parse the current URL parameters
    const urlParams = getUrlParams();

    // Function to format folder names for display
    function formatFolderName(folder) {
        // If the folder name contains 'hidden', and URL parameters do not allow showing hidden folders, return null
        const urlParams = new URLSearchParams(window.location.search);
        const showHiddenFolders = urlParams.has('naughty');
        if (folder.toLowerCase().includes('hidden') && !showHiddenFolders) {
            return null;
        }

        // Remove 'hidden' from the folder name if it's allowed to be shown
        let formattedFolderName = folder;
        if (showHiddenFolders) {
            formattedFolderName = formattedFolderName.replace(/hidden/gi, '').trim();
        }

        // Replace underscores, hyphens with spaces, '+' with an apostrophe, and capitalize words
        formattedFolderName = formattedFolderName.replace(/[_-]/g, ' ').replace(/\+/g, "'")
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
            .join(' ');

        return formattedFolderName;
    }


    // Function to format button names for display
    function formatButtonName(fileName) {
        // Remove file extension and replace underscores, hyphens with spaces
        return fileName.replace(/\.[^/.]+$/, '') // Remove extension
            .replace(/[_-]/g, ' ') // Replace underscores, hyphens with spaces
            .replace(/\+/g, "'") // Replace '+' with an apostrophe
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
            .join(' ');
    }

    function buildSoundboard(soundFiles) {
        const soundboard = $('#sound-buttons');
        soundboard.empty(); // Clear existing contents

        const folders = {};

        // Organize sound files by their folder paths
        soundFiles.forEach(filePath => {
            const parts = filePath.split('/');
            const fileName = parts.pop();
            const folderPath = parts.join('/') || 'Root';

            if (!folders[folderPath]) {
                folders[folderPath] = [];
            }
            folders[folderPath].push(filePath);
        });

        // Create UI elements for folders and files
        Object.keys(folders).forEach(folder => {
            const formattedFolderName = formatFolderName(folder);
            // Skip folders that are meant to be hidden and are not allowed by URL params
            if (formattedFolderName === null) return;

            const folderElem = $(`<div class="folder">${formattedFolderName || 'Root'}</div>`);
            const fileList = $('<div class="file-list"></div>');

            folders[folder].forEach(filePath => {
                const fileName = filePath.split('/').pop(); // Extract file name from path
                const formattedButtonName = formatButtonName(fileName);
                const soundButton = $(`<button class="btn sound-btn">${formattedButtonName}</button>`).click(function () {
                    playSound(filePath);
                });
                fileList.append(soundButton);
            });

            folderElem.click(function () {
                $(this).toggleClass('open'); // Toggle 'open' class to change the icon
                fileList.toggle(); // Toggle visibility on click
            });

            soundboard.append(folderElem).append(fileList);
        });
    }

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

    $('.toast').toast({
        animation: true,
        autohide: true,
        delay: 5000 // Adjust the delay as needed
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
            audio.play().then(() => {
                let soundName = soundFile.name.split('/').pop(); // Extract file name from path
                soundName = formatButtonName(soundName);
                // Show the toast with the sound name
                $('#soundToast .toast-body').text(`Playing: ${soundName}`);
                $('#soundToast').toast('show');
            }).catch(error => console.error("Error playing sound:", error));
    
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

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
          navigator.serviceWorker.register('./service-worker.js').then(registration => {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
          }, err => {
            console.log('ServiceWorker registration failed: ', err);
          });
        });
      }
      
    
});
