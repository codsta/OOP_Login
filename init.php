<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  require 'classes/Database.php';
  require 'classes/Users.php';

?>
