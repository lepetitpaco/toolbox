<?php
// Get the root directory of the website
$root_dir = $_SERVER['DOCUMENT_ROOT'] . '/';


// Get the root directory of the website
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '/';

// Get a list of all directories in the root directory
$dirs = array_filter(glob($root_dir . '*'), 'is_dir');
$forbidden_folders = array('vendor');
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <a class="navbar-brand" href="https://lepetitpaco.com/">Toolbox</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php foreach ($dirs as $dir):
                    $dir_name = basename($dir);
                    if (!in_array($dir_name, $forbidden_folders)): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl.$dir_name; ?>"><?php echo ucfirst($dir_name); ?></a></li>
                    <?php endif;
                endforeach; ?>
            </ul>
        </div>
        <form class="d-flex" action="index.php" method="post">
            <?php if (isset($_POST['logout'])):
                session_unset();
                session_destroy();
                header("location: ./");
                exit;
            endif; ?>
            <button type="submit" class="btn btn-danger" name="logout" onclick="alert('That\'s what I thought')" data-bs-to²le="tooltip" data-bs-placement="bottom" title="Yea, get the fuck out" style="margin-right: 10px;">Fuck outta here</button>
        </form>

        <?php if(isset($_SESSION['username'])): ?>
            <div class="navbar-text d-flex justify-content-center" style="margin-right: 10px;">Welcome, <?php echo ucfirst($_SESSION['username']); ?>!</div>
        <?php endif; ?>
    </div>
</nav>


