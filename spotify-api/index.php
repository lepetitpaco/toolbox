<?php
// Redirect if not logged in
// include('../login_redirect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Playlists</title>
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file here -->
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file here -->
</head>

<body>
    <div id="topBar">
        <div id="userInput">
            <input type="text" id="spotifyUsername" placeholder="Enter Spotify Username" />
            <button id="fetchUserPlaylists">Fetch Playlists</button>
            <button id="resetToDefault">Reset</button>
        </div>
    </div>
    <ul id="playlistItems"></ul>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>

</body>

</html>