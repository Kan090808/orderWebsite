<?php
session_start();
require("config.php");

function login($userName, $passWord)
{
  global $conn;
  $sql = "SELECT * FROM `user` WHERE `userName`='" . $userName . "' AND `passWord`='" . $passWord . "'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $_SESSION["login"] = "yes";
    $_SESSION["userName"] = (mysqli_fetch_assoc($result))["userName"];
  } else {
    $_SESSION["failed"] = "logIn";
    unset($_SESSION["signUp"]);
  }
  header("location:index.php");
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
    header("location:signUp.php");
  } else {
    $sql = "INSERT INTO `user` (`userName`, `passWord`, `phoneNum`) VALUE ('" . $userName . "', '" . $passWord . "', " . $phoneNum . ")";
    if (mysqli_query($conn, $sql)) {
      $_SESSION["signUp"] = "yes";
      unset($_SESSION["failed"]);
      header("location:login.php");
    } else {
      $_SESSION["failed"] = "signUp";
      header("location:signUp.php");
    }
  }
}

function showbySeries()
{
  global $conn;
  mysqli_query($conn, "set names utf8");
  $sql = "SELECT * FROM `product` GROUP BY `productName`";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td name='productName'>
      <input type='submit' class='btn btn-info select-btn' 
       value='選擇' id='" . $row['productName'] . "'>
      &nbsp;&nbsp;" . $row['productName'] . "</td>";
    echo "<td class='series'>" . $row['series'] . "</td>";
    echo "</tr>";
  }
}

function showMenu()
{
  global $conn;
  mysqli_query($conn, "set names utf8");
  $sql = "SELECT * FROM `product`";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    echo '<div class="table-responsive">
          <table class="table table-striped">
            <thead><tr><th>名稱</th><th>大小</th><th>單價</th></tr></thead>
            <tbody id="menuTable">';
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row['productName'] . "</td>";
      echo "<td class='series'>" . $row['series'] . "</td>";
      echo "<td>" . $row['size'] . "</td>";
      echo "<td>" . $row['price'] . "</td>";
      echo "</tr>";
    }
    echo '</tbody></table></div>';
  } else {
    echo '<h3>目前沒有商品哦~</h3>';
  }
}

function seriesBtn()
{
  global $conn;
  mysqli_query($conn, "set names utf8");
  $sql = "SELECT `series` FROM `product` GROUP BY `series`";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    echo '<button class="btn btn-success btn-series" id="' . $row["series"] . '">' . $row["series"] . '</button>';
  }
}

function selectProduct($productName)
{
  // array_push($_SESSION["cart"], $productName);
  global $conn;
  mysqli_query($conn, "set names utf8");
  //取得相同產品名稱的資料
  $sql = "SELECT * FROM `product` WHERE `productName` = '" . $productName . "'";
  $result = mysqli_query($conn, $sql);
  $selectedName = array();
  $selectedSize = array();
  $selectedPrice = array();
  while ($row = mysqli_fetch_assoc($result)) {
    array_push($selectedName, $row["productName"]);
    array_push($selectedSize, $row["size"]);
    array_push($selectedPrice, $row["price"]);
  }
  $result = array($selectedName, $selectedSize, $selectedPrice);
  echo json_encode($result);

  // header("location:index.php");
}

function showCart()
{
  if (isset($_SESSION["cart"])) {
    if (sizeof($_SESSION["cart"]) > 0) {
      for ($i = 0; $i < sizeof($_SESSION["cart"]); $i++) {
        list($name, $size, $price, $num, $sweet, $ice, $note) = $_SESSION["cart"][$i];
        echo '<tr id="row' . $i . '">';
        echo '<td><button id="' . $i . '" class="btn btn-info btn-cart edit-btn">修改</button>';
        echo '<button class="btn btn-warning btn-cart cancel-btn" name="cancel" value="' . $i . '">刪除</button></td>';
        echo '<td name="' . $name . '" class="cartproName">' . $name . '</td>';
        echo '<td>' . $size . '</td>';
        echo '<td class="price">' . $price . '</td>';
        echo '<td class="num">' . $num . '</td>';
        echo '<td>' . $sweet . '</td>';
        echo '<td>' . $ice . '</td>';
        echo '<td>' . $note . '</td>';
        echo '</tr>';
      }
    } else {
      echo "<h1 id='cartMessage'>購物車內還沒有商品哦~</h1>";
    }
  } else {
    $_SESSION["cart"] = array();
  }
}

function clearCart()
{
  $_SESSION["cart"] = array();
  header("location:index.php");
}

function addtoCart($name, $size, $price, $num, $sweet, $ice, $note)
{
  $arr = array($name, $size, $price, $num, $sweet, $ice, $note);
  array_push($_SESSION["cart"], $arr);
  $i = sizeof($_SESSION["cart"]) - 1;
  // header("location:index.php");
  echo $i;
}

function cancelProduct($id)
{
  unset($_SESSION["cart"][$id]);
  // var_dump($_SESSION["cart"]);
  // $_SESSION["cart"] = array_values($_SESSION["cart"]);
  // header("location:index.php");
}

function editProduct($id)
{
  list($name, $size, $price, $num, $sweet, $ice, $note) = $_SESSION["cart"][$id];
  global $conn;
  mysqli_query($conn, "set names utf8");
  //取得相同產品名稱的資料
  $sql = "SELECT * FROM `product` WHERE `productName` = '" . $name . "'";
  $result = mysqli_query($conn, $sql);
  $selectedName = $name;
  $selectedSize = array();
  $nowSize = $size;
  $selectedPrice = array();
  $selectedNum = $num;
  $selectedSweet = $sweet;
  $selectedIce = $ice;
  $selectedNote = $note;
  while ($row = mysqli_fetch_assoc($result)) {
    array_push($selectedSize, $row["size"]);
    array_push($selectedPrice, $row["price"]);
  }
  $result = array(
    $selectedName, $selectedSize, $nowSize,
    $selectedPrice, $selectedNum, $selectedSweet,
    $selectedIce, $selectedNote, $id
  );
  echo json_encode($result, JSON_UNESCAPED_UNICODE);
  // echo json_encode($selectedName, JSON_UNESCAPED_UNICODE);
}

function getTotal()
{
  $total = 0;
  if (isset($_SESSION["cart"])) {
    for ($i = 0; $i < sizeof($_SESSION["cart"]); $i++) {
      list($name, $size, $price, $num, $sweet, $ice, $note) = $_SESSION["cart"][$i];
      $sum = intval($price) * intval($num);
      $total += $sum;
    }
  }
  return $total;
}

function edittoCart($id, $name, $size, $price, $num, $sweet, $ice, $note)
{
  $arr = array($name, $size, $price, $num, $sweet, $ice, $note);
  $_SESSION["cart"][$id] = $arr;
}

function findProductId($name, $size)
{
  global $conn;
  mysqli_query($conn, "set names utf8");
  $sql = "SELECT `productId` FROM `product` WHERE `productName` = '" . $name . "' AND `size` = '" . $size . "'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $id = $row["productId"];
  return $id;
}

function findProductName($idStr)
{
  $idArr = explode(",", $idStr);
  global $conn;
  mysqli_query($conn, "set names utf8");
  for ($i = 0; $i < sizeof($idArr); $i++) {
    $sql = "SELECT * FROM `product` WHERE `productId` = '" . $idArr[$i] . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($i == 0)
      $nameStr = $row["productName"] . "(" . $row["size"] . ")";
    else {
      $nameStr = $nameStr . ", " . $row["productName"] . "(" . $row["size"] . ")";
    }
  }

  return $nameStr;
}

function findTableRow($tableName)
{
  global $conn;
  mysqli_query($conn, "set names utf8");
  $sql = "SELECT COUNT(*) FROM `" . $tableName . "`";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $count = $row["COUNT(*)"];
  return $count;
}
function confirmCart($type)
{
  initCart();
  if (sizeof($_SESSION["cart"]) > 0) {
    $total = getTotal();
    for ($i = 0; $i < sizeof($_SESSION["cart"]); $i++) {
      list($name, $size, $price, $num, $sweet, $ice, $note) = $_SESSION["cart"][$i];
      if ($i == 0) {
        $idList = strval(findProductId($name, $size));
        $numList = strval($num);
        $noteList = strval($note);
        $sweetList = strval($sweet);
        $iceList = strval($ice);
      } else {
        $idList = $idList . "," . strval(findProductId($name, $size));
        $numList = $numList . "," . strval($num);
        $noteList = $noteList . ";" . strval($note);
        $sweetList = $sweetList . "," . strval($sweet);
        $iceList = $iceList . "," . strval($ice);
      }
    }
    global $conn;
    mysqli_query($conn, "set names utf8");
    $sql = "INSERT INTO `bill` (`billNo`,`type`,`productIdList`,`quantityList`,`sweetList`,`iceList`,`totalAmount`,`notesList`,`userName`)
    VALUES (" . strval(intval(findTableRow("bill")) + 1) . ",
    '" . $type . "', '" . $idList . "', '" . $numList . "', '" . $sweetList . "', '" . $iceList . "', " . $total . ",
      ' "  . $noteList  . "', ' "  . $_SESSION["userName"]  . "')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      unset($_SESSION["cart"]);
      echo "訂購成功";
    } else {
      echo "訂購失敗";
    }
  }
}

function showHistory()
{
  echo '<h1>歷史訂單</h1>';
  global $conn;
  mysqli_query($conn, "set names utf8");
  $sql = "SELECT * FROM `bill`";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {

    echo '<div class="table-responsive">
    <table class="table table-striped" id="hisTable"">
  <thead></th><th>時間</th><th>訂餐方式</th><th>購買商品</th>
            <th>購買數量</th><th>共計</th>
          </tr></thead><tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<tr><td>' . $row["time"] . '</td><td>' . $row["type"] . '</td>
    <td>' . findProductName($row["productIdList"]) . '</td>
    <td>' . $row["quantityList"] . '</td><td>' . $row["totalAmount"] . '</td></tr>';
    }
    echo "</tbody></table></div>";
  } else {
    echo '<h3>無購買記錄哦~</h3>';
  }
}

function initCart()
{
  if (isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array_values($_SESSION["cart"]);
  }
}