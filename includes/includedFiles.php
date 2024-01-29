<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
  // page requested via ajax
  include("includes/config.php");
  include("includes/classes/Artist.php");
  include("includes/classes/Album.php");
  include("includes/classes/Song.php");
} else {
  // page manually loaded by user
  include("includes/header.php");
  include("includes/footer.php");

  $url = $_SERVER['REQUEST_URI'];
  echo "<script>openPage('$url')</script>";
  exit();
}

?>