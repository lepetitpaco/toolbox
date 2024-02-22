<?php
    include('../login_redirect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compteur de Mots</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <div class="word-counter">
            <h2>Compteur de Mots</h2>
            <p class="subtext">Ne pas utiliser pour stocker des données importantes.</p>
            <div>
                <button id="add-word-btn" class="btn btn-primary">Ajouter un Mot</button>
            </div>
            <div id="word-list">
                <!-- Words and their counts will be dynamically inserted here -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>

</html>
