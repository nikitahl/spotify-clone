<!DOCTYPE html>

<?php
  include("includes/config.php");

  // Manually log out
  // session_destroy();

  if (isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
  } else {
    header("Location: register.php");
  }
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Spotify Clone</title>
</head>
<body>
Spotify clone
</body>
</html>