<!DOCTYPE html>

<?php
  include("includes/config.php");
  include("includes/classes/User.php");
  include("includes/classes/Artist.php");
  include("includes/classes/Album.php");
  include("includes/classes/Song.php");
  include("includes/classes/Playlist.php");

  // Manually log out
  // session_destroy();

  if (isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
    $username = $userLoggedIn->getUsername();
    echo "<script>userLoggedIn = '$username';</script>";
  } else {
    header("Location: register.php");
  }
?>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Clone</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
  </head>
  <body>

    <div id="mainContainer">

      <div id="topContainer">
        <?php include("includes/navBarContainer.php"); ?>

        <div id="mainViewContainer">
          <div id="mainContent">