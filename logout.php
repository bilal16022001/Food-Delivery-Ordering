<?php
 
  session_start();
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
  session_unset();
  session_destroy();
  header("Location: home.php");
  exit();

?>