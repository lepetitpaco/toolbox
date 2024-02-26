<?php
include('../login_redirect.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications en Temps Réel</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-12">
                <h1>Applications en Temps Réel</h1>
                <p>Bienvenue sur nos applications en temps réel. Choisissez une option ci-dessous pour commencer.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12 mb-3">
                <a href="/realtime/soundboard" class="app-link">
                    <div class="app-entry">
                        <h2>Soundboard</h2>
                        <p>Good Luck</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('https://lepetitpaco.com/assets/img/wallpaper.png');
            background-color: #8b8b8b;
            background-size: cover;
            background-position: center;
            color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background-color: rgba(55, 49, 77, 0.8);
            padding: 20px;
            border-radius: 0.25rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .app-link {
            text-decoration: none;
            color: #f8f9fa;
        }

        .app-link:hover,
        .app-link:focus {
            text-decoration: none;
            /* Remove underline on hover/focus */
        }

        .app-entry {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .app-entry:hover,
        .app-entry:focus {
            transform: scale(1.05);
            background-color: rgba(255, 255, 255, 0.3);
            text-decoration: none;
            /* Ensure no underline effect */
        }

        h2 {
            color: #f8f9fa;
        }

        p {
            color: #f8f9fa;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>