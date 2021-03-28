<?php
session_start();

if (!isset($_SESSION["login"])){
  header("location:views/login.php");
}else{
  header("location:views/index.php");
}


?>