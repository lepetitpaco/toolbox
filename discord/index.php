<?php include('../login_redirect.php'); ?>
<?php
  // Load environment variables
  require __DIR__ . '/../vendor/autoload.php';
  require __DIR__ . '/../../config/config.php';
  $dotenv = Dotenv\Dotenv::createImmutable(getEnvFilePath());
  $dotenv->load();
  $token = $_ENV['DISCORDTOKEN'];
?>
<?php
$userid = $_GET['id'] ?? '152431535914614785';
$curl = curl_init();
curl_setopt_array(
  $curl,
  array(
    CURLOPT_URL => 'https://discord.com/api/users/' . $userid,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => [
      'Authorization: Bot '. $token,
    ],
  )
);

$response = curl_exec($curl);
curl_close($curl);
$data = json_decode($response, true);

$userid = $data['id'];
$username = $data['username'];
$useravatar = $data['avatar'];
$avatar_url = 'https://cdn.discordapp.com/avatars/' . $userid . '/' . $useravatar . '.webp';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

  <title>Add me</title>
  <style>
    :root {
      --card-bg-color: #fff;
      --card-text-color: #333;
      --dark-mode-bg-color: #333;
      --dark-mode-text-color: #fff;
    }

    body {
      background-color: #f2f2f2;
      font-family: Arial, sans-serif;
    }

    .profile-card {
      background-color: var(--card-bg-color);
      color: var(--card-text-color);
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 20px;
      margin: 50px auto;
      max-width: 400px;
    }

    .profile-card img {
      border-radius: 50%;
      height: 150px;
      width: 150px;
      margin-bottom: 20px;
    }

    .profile-card h1 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .profile-card a {
      background-color: #7289da;
      border-radius: 5px;
      color: #fff;
      display: inline-block;
      font-size: 16px;
      padding: 10px 20px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .profile-card a:hover {
      background-color: #677bc4;
    }

    /* Dark mode */
    .dark-mode {
      --card-bg-color: var(--dark-mode-bg-color);
      --card-text-color: var(--dark-mode-text-color);
      background-color: var(--dark-mode-bg-color);
      color: var(--dark-mode-text-color);
    }


    .toggle-button {
      background-color: #7289da;
      border: none;
      border-radius: 50px;
      color: #fff;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      height: 50px;
      width: 50px;
      position: fixed;
      bottom: 20px;
      right: 20px;
      transition: background-color 0.3s ease;
    }

    .toggle-button:hover {
      background-color: #677bc4;
    }

    .toggle-button i {
      transition: transform 0.3s ease;
    }

    .dark-mode .toggle-button {
      background-color: #333;
    }

    .dark-mode .toggle-button:hover {
      background-color: #444;
    }
  </style>
</head>

<body>
  <div class="toggle-container">
    <button id="dark-mode-toggle" class="toggle-button">
      <i class="fas fa-sun"></i>
      <i class="fas fa-moon"></i>
    </button>
  </div>

  <div class="profile-card">
    <img src="<?php echo $avatar_url; ?>" alt="">
    <h1>
      <?php echo $username; ?>
    </h1>
    <a href="https://discord.com/users/<?php echo $userid; ?>">Add <?php echo $username; ?></a>
  </div>

  <script>
    window.onload = function() {
      const sun = document.querySelector('.fa-sun');
      const moon = document.querySelector('.fa-moon');
      moon.style.display = 'none';
      sun.style.display = 'inline-block';
    }

    function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
      const sun = document.querySelector('.fa-sun');
      const moon = document.querySelector('.fa-moon');


      if (document.body.classList.contains('dark-mode')) {
        sun.style.display = 'none';
        moon.style.display = 'inline-block';
      } else {
        sun.style.display = 'inline-block';
        moon.style.display = 'none';
      }
    }

    document.getElementById('dark-mode-toggle').addEventListener('click', toggleDarkMode);

  </script>
</body>

</html>