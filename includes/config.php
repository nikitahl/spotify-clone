<?php
  ob_start();
  session_start();

  $timezone = date_default_timezone_set("Europe/Riga");

  $dbhost='localhost';
  $dbuser ='root';
  $dbpassword ='root';
  $dbdatabase= 'spotify';
  $con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase);

  if (mysqli_connect_errno()) {
    echo "Failed to connect to DB: " . mysqli_connect_errno();
  }

?>