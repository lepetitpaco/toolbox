$(document).ready(function () {
    // Triggered when the 'Fetch Playlists' button is clicked
    $('#fetchUserPlaylists').on('click', function () {
        let input = $('#spotifyUsername').val().trim();

        // Check if input is a Spotify URL and extract the user ID
        if (input.includes('open.spotify.com/user/')) {
            const urlMatches = input.match(/user\/(\w+)/);
            if (urlMatches && urlMatches[1]) {
                input = urlMatches[1]; // Extracted User ID from URL
            } else {
                alert('Invalid Spotify URL. Please check and try again.');
                return;
            }
        }
        // Check for Spotify URI format and extract the user ID
        else if (input.startsWith('spotify:user:')) {
            const uriMatches = input.match(/spotify:user:(\w+)/);
            if (uriMatches && uriMatches[1]) {
                input = uriMatches[1]; // Extracted User ID from URI
            } else {
                alert('Invalid Spotify URI. Please check and try again.');
                return;
            }
        }

        // Proceed with either the extracted ID or the direct input
        if (input) {
            fetchUserProfile(input); // Fetch and display user profile information
            fetchPlaylists(input); // Fetch and display playlists
        } else {
            alert('Please enter a Spotify username, URL, or URI.');
        }
    });

    // Reset to default user's playlists
    $('#resetToDefault').on('click', function () {
        $('#spotifyUsername').val(''); // Clear input field
        // Optionally, fetch and display the default user's profile information here
        fetchPlaylists(); // Call fetchPlaylists without a username to reset to default
    });


    // Fetch and display playlists upon page load for a default or specific user
    fetchPlaylists(); // This will fetch playlists for the default user initially.

    // JavaScript: Function to fetch playlists, optionally for a specific user
    function fetchPlaylists(username = '') {
        $('#playlistItems').empty(); // Clear existing playlists
        $('#loader').show(); // Show a loader here if you have one

        // Determine the URL to use based on whether a username is provided
        const url = username ? `ajax.php?id=${username}` : 'ajax.php';

        $.ajax({
            url: url,
            method: 'GET',
            success: function (response) {
                // Assuming response is the array of playlists
                response.forEach(function (playlist) {
                    $('#playlistItems').append(
                        `<li class='playlist-item' data-playlist-id='${playlist.id}'>
                        <img src='${playlist.images[0].url}' alt='${playlist.name}'>
                        <span>${playlist.name} - ${playlist.tracks.total} songs</span>
                    </li>
                    <ul class='playlist-songs' id='songs-${playlist.id}'></ul>`
                    );
                });
                $('#loader').hide(); // Hide the loader
            },
            error: function () {
                alert('Error fetching playlists. Please try again later.');
                $('#loader').hide(); // Hide the loader on error
            }
        });
    }



    $('#playlistItems').on('click', '.playlist-item', function () {
        const playlistId = $(this).data('playlist-id');
        const songsListId = `#songs-${playlistId}`;
        if ($(songsListId).is(':empty')) {
            fetchPlaylistSongs(playlistId, songsListId);
        }
        $(songsListId).slideToggle();
    });

    function fetchPlaylistSongs(playlistId, songsListId) {
        $('#loader').show(); // Show loader

        $.ajax({
            url: `ajax.php?playlist_id=${playlistId}`,
            method: 'GET',
            success: function (response) {
                const songs = response.items;
                let tableContent = `
                    <table class="songs-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Artist</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>`;
                songs.forEach(song => {
                    let duration = millisToMinutesAndSeconds(song.track.duration_ms);
                    // Add Spotify link to the song title
                    tableContent += `
                        <tr>
                            <td><a href="${song.track.external_urls.spotify}" target="_blank">${song.track.name}</a></td>
                            <td>${song.track.artists.map(artist => artist.name).join(', ')}</td>
                            <td>${duration}</td>
                        </tr>`;
                });
                tableContent += `</tbody></table>`;
                $(songsListId).html(tableContent); // Append table to the song list container

                $('#loader').hide(); // Hide loader after content is loaded
            },
            error: function () {
                alert('Error fetching playlist songs. Please try again later.');
                $('#loader').hide(); // Hide loader even if there's an error
            }
        });
    }

    // Helper function to format duration
    function millisToMinutesAndSeconds(millis) {
        let minutes = Math.floor(millis / 60000);
        let seconds = ((millis % 60000) / 1000).toFixed(0);
        return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
    }

    function fetchUserProfile(userId) {
        $('#displayName').remove();
        $.ajax({
            url: `ajax.php?action=fetchUserProfile&id=${userId}`,
            method: 'GET',
            success: function (response) {
                // Check if the response contains the display name
                if (response && response.display_name) {
                    // Update the top bar with the username
                    $('#userInput').append(`<div id="displayName">${response.display_name}</div>`);
                } else {
                    alert('User profile could not be fetched.');
                }
            },
            error: function () {
                alert('Error fetching user profile. Please try again later.');
            }
        });
    }
});