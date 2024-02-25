<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/../config/config.php';

$dotenv = Dotenv\Dotenv::createImmutable(getEnvFilePath());
$dotenv->load();


$credentials = array(
  $_ENV['USERNAME1'] => $_ENV['PASSWORD1'],
  $_ENV['USERNAME2'] => $_ENV['PASSWORD2'],
  $_ENV['USERNAME3'] => $_ENV['PASSWORD3'],
  $_ENV['USERNAME4'] => $_ENV['PASSWORD4'],
);

// Start the session
session_start();
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the username and password from the form data
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Check if the username and password are correct

  if (array_key_exists($username, $credentials) && $credentials[$username] == $password) {
    // Set the session variable to indicate that the user is logged in
    $_SESSION["loggedin"] = true;
    $_SESSION["username"] = $username;

    // Redirect the user to the home page
    header("location: ./");
    exit;
  } else {
    // Display an error message
    echo "<script>alert('Invalid username or password.');window.location.href='index.php';</script>";
  }
}
?>


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <style>
    /* Style the form container */
    .form-container {
      font-family: 'Roboto', sans-serif;
      width: 300px;
      padding: 20px;
      background-color: #424242;
      border-radius: 10px;
      margin: auto;
      margin-top: 50px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }

    /* Style the form labels */
    label {
      display: block;
      font-weight: bold;
      margin-bottom: 10px;
      color: #fff;
    }

    /* Style the form input fields */
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      margin-bottom: 20px;
      box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }

    /* Style the form submit button */
    input[type="submit"] {
      background-color: #26a69a;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease-in-out;
    }

    /* Style the form submit button on hover */
    input[type="submit"]:hover {
      background-color: #00897b;
    }

    /* Center the form */
    .row {
      display: flex;
      justify-content: center;
    }

    /* Make the background darker */
    body {
      background-color: #212121;
    }
  </style>
</head>

<body>
  <div class="form-container">
    <form action="" method="post">
      <div class="input-field">
        <label for="username">Username:</label>
        <input required type="text" id="username" name="username">
      </div>
      <div class="input-field">
        <label for="password">Password:</label>
        <input required type="password" id="password" name="password">
      </div>
      <button class="btn waves-effect waves-light" type="submit" value="Submit" name="action">
        <i class="material-icons">send</i>
      </button>
    </form>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>