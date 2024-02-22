<?php
// Get the root directory of the website
$root_dir = $_SERVER['DOCUMENT_ROOT'] . '/';

// Get the root directory of the website
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '/';

// Get a list of all directories in the root directory
$dirs = array_filter(glob($root_dir . '*'), 'is_dir');
$forbidden_folders = array('vendor');
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="https://lepetitpaco.com/">Toolbox</a>

        <form class="d-flex" action="index.php" method="post">
            <?php if (isset($_POST['logout'])):
                session_unset();
                session_destroy();
                header("location: ./");
                exit;
            endif; ?>
            <button style="margin-right:10px;" type="submit" class="btn btn-danger me-2" name="logout" onclick="alert('That\'s what I thought')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Yea, get the fuck out">Fuck outta here</button>
            <?php if(isset($_SESSION['username'])): ?>
                <div class="navbar-text mr-2 d-none d-lg-block">Welcome, <?php echo ucfirst($_SESSION['username']); ?>!</div>
            <?php endif; ?>
        </form>
    </div>
</nav>


