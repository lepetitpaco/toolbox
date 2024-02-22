<?php include('./login_redirect.php'); ?>
<?php
// Start the session
session_start();

// Get the root directory of the website
$root_dir = $_SERVER['DOCUMENT_ROOT'] . '/';

// Get the root directory of the website
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '/';

// Get a list of all directories in the root directory
$dirs = array_filter(glob($root_dir . '*'), 'is_dir');
$forbidden_folders = array('vendor');
?>

<?php include('menu.php'); ?>

<!DOCTYPE html>
<html lang="fr">

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boîte à Outils - Le Petit Paco</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .jumbotron {
            background-color: #f8f9fa;
            color: #212529;
            border-radius: 0;
            text-align: justify;
            margin-bottom: 20px;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .card {
            cursor: pointer;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            text-decoration: none;
        }

        .card-body {
            padding: 1.25rem;
            text-align: center;
        }

        .card-title {
            margin-bottom: 0.75rem;
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Bienvenue dans la Boîte à Outils</h1>
            <p class="lead">Ici, vous ne trouverez probablement pas ce dont vous avez besoin en ce moment, mais je vous
                propose d'autres choses dont vous n'aurez pas besoin. Ma collection d'outils est vaste et variée, et je
                suis
                sûr que vous trouverez quelque chose dont vous n'avez pas besoin. <br> Mes outils sont conçus pour être
                une
                vraie prise de tête et compliqués à utiliser, même si vous en avez besoin.</p>
            <hr class="my-4">
            <p>Explorez mes sous-dossiers pour trouver les outils dont vous n'avez pas besoin. Nous espérons que vous
                trouverez mon site inutile.</p>
        </div>

        <div class="row">
            <?php
            // Directories to exclude from the loop
            $excluded_dirs = ['anilist', 'vendor'];

            foreach ($dirs as $dir):
                $dir_name = basename($dir);
                if (in_array($dir_name, $excluded_dirs))
                    continue;
                ?>
                <div class="col-md-4">
                    <a href="<?php echo $baseUrl . $dir_name; ?>" class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo ucfirst($dir_name); ?>
                            </h5>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>