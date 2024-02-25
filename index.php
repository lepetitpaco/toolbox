<?php include('./login_redirect.php'); ?>
<?php
session_start();

// Define the base URL
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '/';

// Define directories to exclude from listing
$excluded_dirs = ['.', '..', 'vendor','assets'];

// Get the root directory of the website
$root_dir = $_SERVER['DOCUMENT_ROOT'];

// Get a list of all directories in the root directory, excluding specific ones
$dirs = array_filter(glob($root_dir . '/*'), 'is_dir');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Useless shit you won't need anyways but you got access to it so you might as well try and suffer a bit. Well
        fuck I'm tired of this life I wish I could code a button that ends me on the spot but I can't even do that, fml,
        I'm going to watch animes.</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('https://lepetitpaco.com/assets/img/wallpaper.png');
            background-color: #8b8b8b;
            /* Fallback color */
            background-size: cover;
            /* Cover the entire page */
            background-position: center;
            /* Center the background image */
            color: #f8f9fa;
            /* Light color for better contrast and readability */
            height: 100vh;
            display: block;
            align-items: center;
            justify-content: center;
        }

        .navbar {
            background-color: rgba(55, 49, 77, 0.8);
            border-radius: 0.25rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: #f8f9fa;
            width: 100%;
        }

        .navbar-brand {
            flex-grow: 1;
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .navbar-items {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }


        @media (max-width: 768px) {
            .navbar-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar-items {
                text-align: left;
                margin-top: 10px;
            }
        }

        .container {
            background-color: rgba(55, 49, 77, 0.8);
            padding: 20px;
            border-radius: 0.25rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 70px;
            /* Adjust margin to avoid overlapping with navbar */
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

        h1,
        h2,
        p {
            color: #f8f9fa;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="navbar-container">
            <div class="navbar-brand">
                <a href="<?php echo $baseUrl; ?>">Toolbox</a>
            </div>
            <div class="navbar-items">
                <div class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION['username'])): ?>
                        <span class="navbar-text mr-2">Welcome,
                            <?php echo ucfirst($_SESSION['username']); ?>!
                        </span>
                    <?php endif; ?>
                    <form class="form-inline" action="index.php" method="post">
                        <?php if (isset($_POST['logout'])):
                            session_unset();
                            session_destroy();
                            header("location: ./");
                            exit;
                        endif; ?>
                        <button type="submit" class="btn btn-danger" name="logout"
                            onclick="alert('That\'s what I thought')" data-bs-to²le="tooltip" data-bs-placement="bottom"
                            title="Yea, get the fuck out" style="margin-right: 10px;">Fuck outta here</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-12">
                <h1>Toolbox</h1>
                <p>You probably won't find what you need right now, but I offer you other stuff you won't
                need. My collection of tools is vast and varied, and I am sure you'll find something that you don't
                need. <br>My tools are designed to be a pain in the ass and complicated to use, even if you need them.</p>
            </div>
        </div>

        <div class="row">
            <?php foreach ($dirs as $dir):
                $dir_name = basename($dir);
                if (in_array($dir_name, $excluded_dirs))
                    continue; // Skip excluded directories
                $relativePath = str_replace($root_dir, '', $dir); // Get the relative path from the root directory
                ?>
                <div class="col-md-6 col-sm-12 mb-3">
                    <a href="<?php echo $baseUrl . ltrim($relativePath, '/'); ?>" class="app-link">
                        <div class="app-entry">
                            <h2>
                                <?php echo ucfirst($dir_name); ?>
                            </h2>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>