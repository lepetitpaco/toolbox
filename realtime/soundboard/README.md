# Soundboard Application Workflow

This document outlines the order of execution for both the PHP (server-side) and JavaScript (client-side) components of the Soundboard application during two key events: loading the page and clicking a button.

## Upon Loading the Page

### Client-Side (JavaScript)

1. The browser loads the HTML document.
2. External resources are fetched, including CSS files, JavaScript files, and the jQuery library.
3. JavaScript waits for the DOM to be fully loaded using `$(document).ready(function () {...});`.
4. A WebSocket connection is established to the server with `var conn = new WebSocket('wss://lepetitpaco.com/ws');`.

### Server-Side (PHP)

1. The `onOpen` method in the PHP `Soundboard` class is triggered upon establishing the WebSocket connection.
2. This method:
   - Adds the new connection to the `$clients` storage.
   - Prepares and sends a list of sound files back to the client as a `sound_init_sounds` action message.
   - Logs the new connection and inserts a record into the database.

## On Clicking a Sound Button

### Client-Side

1. A user clicks one of the dynamically generated sound buttons.
2. The click event triggers the `playSound` function, which:
   - Constructs a message with `action: 'sound_play'` and the `sound_file` name.
   - Sends this message to the server via WebSocket.

### Server-Side

1. The `onMessage` method of the `Soundboard` class is invoked upon message receipt.
2. This method:
   - Logs the received message and decodes it.
   - Checks if the action is `sound_play`. If so, it calls `playSound` with the specified sound file name.
   - The `playSound` method then loops through all connected clients, sending a `sound_play` action message indicating which sound file should be played.

### Client-Side (Response to Server Message)

1. The `conn.onmessage` event handler is triggered upon receiving a `sound_play` action message from the server.
2. It directly plays the specified sound file without sending another message back to the server, using a new `Audio` object and calling its `play` method.

## Summary

- **Page Load**: Initiates setup and establishes a WebSocket connection. The server prepares and sends initial data (like the sound files list) to the client.
- **Clicking a Sound Button**: Involves client-to-server request and server-to-all-clients broadcasting, culminating in the sound being played as per the server's instruction.
