<?php
require("model.php");
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
  case "selectProduct":
    selectProduct($_REQUEST["productName"]);
    break;
  case "clearCart":
    clearCart();
    break;
  case "addtoCart":
    addtoCart($_REQUEST["addtoName"], $_REQUEST["addtoSize"], $_REQUEST["addtoPrice"], $_REQUEST["addtoNum"], $_REQUEST["addtoSweet"], $_REQUEST["addtoIce"], $_REQUEST["addtoNote"]);
    break;
  case "cancelProduct":
    cancelProduct($_REQUEST["productId"]);
    break;
  case "editProduct":
    editProduct($_REQUEST["productName"]);
    break;
  case "edittoCart":
    edittoCart($_REQUEST["productId"], $_REQUEST["addtoName"], $_REQUEST["addtoSize"], $_REQUEST["addtoPrice"], $_REQUEST["addtoNum"], $_REQUEST["addtoSweet"], $_REQUEST["addtoIce"], $_REQUEST["addtoNote"]);
    break;
  case "confirmCart":
    confirmCart($_REQUEST["type"]);
    break;
}