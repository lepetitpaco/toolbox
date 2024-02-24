<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compteur de Mots</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div id="activeUsers">0</div>
    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-12">
                <h1>Compteur de Mots</h1>
                <p class="subtext">Ne pas utiliser pour stocker des données importantes.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button id="add-word-btn" class="btn add-word-btn">Ajouter un Mot</button>
                <div id="word-list" class="mt-3">
                    <!-- Words and their counts will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>

</html>