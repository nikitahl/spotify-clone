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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <div id="nowPlayingBarContainer">
      <div id="nowPlayingBar">

        <div id="nowPlayingLeft"></div>

        <div id="nowPlayingCenter">
          <div class="content playerControls">
            <div class="buttons">
              <button class="controlButton shuffle" title="Shuffle">
                <i class="fa-solid fa-shuffle"></i>
              </button>
              <button class="controlButton previous" title="Previous">
                <i class="fa-solid fa-arrow-left"></i>
              </button>
              <button class="controlButton play" title="Play">
                <i class="fa-solid fa-play"></i>
              </button>
              <button class="controlButton pause" title="Pause" style="display:none">
                <i class="fa-solid fa-pause"></i>
              </button>
              <button class="controlButton next" title="Next">
                <i class="fa-solid fa-arrow-right"></i>
              </button>
              <button class="controlButton repeat" title="Repeat">
                <i class="fa-solid fa-repeat"></i>
              </button>
            </div>

            <div class="playbackBar">
              <span class="progressTime current">0:00</span>
              <div class="progressBar"></div>
              <span class="progressTime remaining">0:00</span>
            </div>
          </div>
        </div>

        <div id="nowPlayingRight"></div>

      </div>
    </div>

  </body>
</html>