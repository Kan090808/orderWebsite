<?php
require_once("model/model.php");
$action = $_REQUEST['act'];
switch ($action) {
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
    editProduct($_REQUEST["productId"]);
    break;
  case "edittoCart":
    edittoCart($_REQUEST["productId"], $_REQUEST["addtoName"], $_REQUEST["addtoSize"], $_REQUEST["addtoPrice"], $_REQUEST["addtoNum"], $_REQUEST["addtoSweet"], $_REQUEST["addtoIce"], $_REQUEST["addtoNote"]);
    break;
  case "confirmCart":
    confirmCart($_REQUEST["billType"]);
    break;
  case "getTotal":
    getTotal();
    break;
}