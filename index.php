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
    <title>Useless shit you won't need anyways but you got access to it so you might as well try and suffer a bit. Well
        fuck I'm tired of this life I wish I could code a button that ends me on the spot but I can't even do that, fml,
        I'm going to watch animes.</title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    .jumbotron {
        background-color: #f8f9fa;
        color: #212529;
        border-radius: 0;
        text-align: justify;
        margin-bottom: 20px;
        margin-top: 20px;
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
        <div class="row">
            <div class="col-12">
                <div class="jumbotron">
                    <h1 class="display-4">Welcome to the Toolbox</h1>
                    <p class="lead">Hey there! Looking for something you probably won't find here? Well, you're in luck!
                        Dive
                        into my treasure trove of useless stuff. My collection of tools is as vast and varied as it
                        gets,
                        offering you an array of things you definitely don't need. But hey, why not have some fun
                        exploring
                        anyway?</p>
                    <hr class="my-4 bg-light">
                    <p>My tools are like puzzles – frustratingly complicated, even when you're desperate. So, if you're
                        ready to
                        embark on a journey of unnecessary complexity, you've come to the right place.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            // Directories to exclude from the loop
            $excluded_dirs = ['vendor'];

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