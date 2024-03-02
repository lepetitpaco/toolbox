# AJAX Handler for Spotify API

This PHP script handles AJAX requests for a music application, interacting with the Spotify API to fetch user profiles, playlists, and songs from specific playlists. It uses the client credentials flow for Spotify API authentication, which is suitable for server-to-server requests that don't involve end user authorization.

## Setup

The script starts by enabling error reporting for debugging and loading environment variables and configurations. The environment variables include the Spotify client ID and client secret, which are used for API authentication.

## Functions

### fetchUserPlaylists

This function fetches a user's playlists from the Spotify API. It first authenticates with the Spotify API to get an access token. Then, it uses this access token to fetch the playlists of a specific user. If a user ID is provided in the GET request, it's used; otherwise, a default user ID from the environment variables is used. The playlists are fetched in batches of 50 (the maximum allowed by the Spotify API) until there are no more playlists to fetch.

### fetchPlaylistSongs

This function fetches the songs from a specific playlist. It follows a similar process to `fetchUserPlaylists`, first authenticating with the Spotify API to get an access token, then using this access token to fetch the songs from the specified playlist.

### fetchUserProfile

This function fetches a user's profile from the Spotify API. It also authenticates with the Spotify API to get an access token, then uses this access token to fetch the profile of the specified user.

## Main Execution Block

The main execution block of the script handles AJAX requests. If the `action` parameter in the GET request is set to 'fetchUserProfile' and a user ID is provided, the script fetches the user profile associated with that ID. If a playlist ID is provided in the GET request, the script fetches the songs for the specified playlist. If neither of these conditions are met, the script fetches the playlists for a user. If any exceptions occur during the execution of the script, they are caught and a 400 Bad Request response is returned with the error message.