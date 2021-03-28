<?php
require_once("model/loginModel.php");
$action = $_REQUEST['act'];
switch ($action) {
  case "login":
    login($_REQUEST["userName"], $_REQUEST["passWord"]);
    break;
  case "logout":
    logout();
    break;
  case "signUp":
    signUp($_REQUEST["userName"], $_REQUEST["passWord"], $_REQUEST["phoneNum"]);
    break;
  default:
    break;
}