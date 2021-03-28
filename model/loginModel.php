<?php
session_start();
require_once("config.php");

function login($userName, $passWord)
{
  global $conn;
  $sql = "SELECT * FROM `user` WHERE `userName`='" . $userName . "' AND `passWord`='" . $passWord . "'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $_SESSION["login"] = "yes";
    $_SESSION["userName"] = mysqli_fetch_assoc($result)["userName"];
  } else {
    $_SESSION["failed"] = "logIn";
    unset($_SESSION["signUp"]);
  }
  header("location:views/index.php");
}

function logout()
{
  session_destroy();
  header("location:index.php");
}

function signUp($userName, $passWord, $phoneNum)
{
  global $conn;
  $sql = "SELECT * FROM `user` WHERE `userName`='" . $userName . "'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $_SESSION["failed"] = "suName";
    header("location:views/signUp.php");
  } else {
    $sql = "INSERT INTO `user` (`userName`, `passWord`, `phoneNum`) VALUE ('" . $userName . "', '" . $passWord . "', " . $phoneNum . ")";
    if (mysqli_query($conn, $sql)) {
      $_SESSION["signUp"] = "yes";
      unset($_SESSION["failed"]);
      header("location:views/login.php");
    } else {
      $_SESSION["failed"] = "signUp";
      header("location:views/signUp.php");
    }
  }
}
?>