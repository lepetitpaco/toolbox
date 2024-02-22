<?php
    include('../login_redirect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Counter</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <div class="word-counter">
            <h2>Compteur</h2>
            <i>A ne pas utiliser pour stocker des données importantes</i>
            <div><button id="add-word-btn" class="btn btn-primary">Add Word</button></div>
            <div id="word-list">
                <!-- Words and their counts will be dynamically inserted here -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>

</html>