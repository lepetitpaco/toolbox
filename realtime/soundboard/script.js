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


    function buildSoundboard(soundFiles) {
        const soundboard = $('#sound-buttons');
        soundboard.empty(); // Clear existing contents

        const directoryTree = {};
        soundFiles.forEach(filePath => {
            const parts = filePath.split('/');
            let currentLevel = directoryTree;

            for (let i = 0; i < parts.length; i++) {
                const part = parts[i];
                const isFile = i === parts.length - 1;

                if (isFile) {
                    if (!currentLevel.files) currentLevel.files = [];
                    currentLevel.files.push(filePath);
                } else {
                    if (!currentLevel[part]) currentLevel[part] = {};
                    currentLevel = currentLevel[part];
                }
            }
        });

        // Check URL parameters for 'naughty'
        const urlParams = new URLSearchParams(window.location.search);
        const showHiddenFolders = urlParams.has('naughty');

        function buildDirectoryUI(directory, container, path = '', level = 0) {
            const sortedKeys = Object.keys(directory).sort((a, b) => {
                if (a === 'files') return 1;
                if (b === 'files') return -1;
                return a.localeCompare(b);
            });
        
            const showHiddenFolders = new URLSearchParams(window.location.search).has('naughty');
        
            sortedKeys.forEach(key => {
                if (key === 'files') {
                    directory.files.forEach(filePath => {
                        const fileName = filePath.split('/').pop();
                        const formattedButtonName = formatButtonName(fileName);
                        const soundButton = $(`<button class="btn sound-btn">${formattedButtonName}</button>`)
                            .click(() => playSound(filePath));
                        container.append(soundButton);
                    });
                } else {
                    if (key.toLowerCase().includes('hidden') && !showHiddenFolders) return;
        
                    const isSubfolder = level > 0;
                    const folderClass = isSubfolder ? 'folder subfolder' : 'folder';
                    const formattedFolderName = formatFolderName(key, showHiddenFolders);
                    
                    // Wrap the folder and file list together in a div
                    const folderGroup = $('<div class="folder-group"></div>');
                    const folderElem = $(`<div class="${folderClass}">${formattedFolderName}</div>`);
                    const fileList = $('<div class="file-list" style="display: none;"></div>');
        
                    buildDirectoryUI(directory[key], fileList, path + key + '/', level + 1);
                    folderElem.click(() => {
                        folderElem.toggleClass('open');
                        fileList.toggle();
                    });
        
                    folderGroup.append(folderElem).append(fileList);
                    container.append(folderGroup);
                }
            });
        }
        
        

        buildDirectoryUI(directoryTree, soundboard);
    }

    function formatFolderName(folder, showHiddenFolders) {
        let formattedFolderName = folder;

        // If not showing hidden folders, return null if folder is hidden
        if (folder.toLowerCase().includes('hidden') && !showHiddenFolders) {
            return null;
        }

        // Remove the word 'hidden' from the folder name if showing hidden folders
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

    function formatButtonName(fileName) {
        return fileName.replace(/\.[^/.]+$/, '')
            .replace(/[_-]/g, ' ')
            .replace(/\+/g, "'")
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
            .join(' ');
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
