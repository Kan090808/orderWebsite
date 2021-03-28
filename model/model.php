<?php
session_start();
require_once("../config.php");

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
    }
  } else {
    $_SESSION["cart"] = array();
  }
}

function clearCart()
{
  $_SESSION["cart"] = array();
  header("location:views/index.php");
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
  $nameArr = array();
  global $conn;
  mysqli_query($conn, "set names utf8");
  for ($i = 0; $i < sizeof($idArr); $i++) {
    $sql = "SELECT * FROM `product` WHERE `productId` = '" . $idArr[$i] . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nameStr = $row["productName"] . "(" . $row["size"] . ")";
    array_push($nameArr, $nameStr);
  }

  return $nameArr;
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
        $priceList = strval($price);
        $numList = strval($num);
        $noteList = strval($note);
        $sweetList = strval($sweet);
        $iceList = strval($ice);
      } else {
        $idList = $idList . "," . strval(findProductId($name, $size));
        $priceList = $priceList . "," . strval($price);
        $numList = $numList . "," . strval($num);
        $noteList = $noteList . ";" . strval($note);
        $sweetList = $sweetList . "," . strval($sweet);
        $iceList = $iceList . "," . strval($ice);
      }
    }
    global $conn;
    mysqli_query($conn, "set names utf8");
    $sql = "INSERT INTO `bill` (`billNo`,`type`,`productIdList`,`priceList`,`quantityList`,`sweetList`,`iceList`,`totalAmount`,`notesList`,`userName`)
    VALUES (" . strval(intval(findTableRow("bill")) + 1) . ",
    '" . $type . "', '" . $idList . "', '" . $priceList . "','" . $numList . "', '" . $sweetList . "', '" . $iceList . "', " . $total . ",
      ' "  . $noteList  . "', '"  . $_SESSION["userName"]  . "')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      unset($_SESSION["cart"]);
      echo "訂購成功~";
    } else {
      echo "訂購失敗！";
      echo $sql;
    }
  } else {
    echo "購物車內沒有商品哦~";
  }
}

function showHistory()
{
  echo '<h1>歷史訂單</h1>';
  global $conn;
  mysqli_query($conn, "set names utf8");
  $sql = "SELECT * FROM `bill` WHERE `bill`.`userName` = '" . $_SESSION["userName"] . "'ORDER BY `bill`.`time` DESC";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $nameArr = findProductName($row["productIdList"]);
      $priceArr = explode(",", $row["priceList"]);
      $numArr = explode(",", $row["quantityList"]);
      $sweetArr = explode(",", $row["sweetList"]);
      $iceArr = explode(",", $row["iceList"]);
      $noteArr = explode(";", $row["notesList"]);
      $numTotal = 0;
      for ($i = 0; $i < sizeof($numArr); $i++) {
        $numTotal += $numArr[$i];
      }

      echo '<div class="panel panel-default">
    <div class="panel-heading" class="panel-title" data-toggle="collapse" data-target="#bill' . $row["billNo"] . '">
      <div class="row">
        <b class="col-md-2">訂單號碼：' . $row["billNo"] . '</b>  
        <b class="col-md-2">方式：' . $row["type"] . '</b>  
        <b class="col-md-2">數量：' . $numTotal . '</b>  
        <b class="col-md-2 col-xs-12">總額：' . $row["totalAmount"] . '</b>
        <b class="col-md-4 col-xs-12">時間：' . $row["time"] . '</b>
      </div>
    </div>';
      echo '<div class="panel-collapse collapse" id="bill' . $row["billNo"] . '">
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead><tr><th>商品</th><th>單價</th><th>數量</th><th>小計</th><th>甜度</th><th>冰塊</th><th>備註</th></tr></thead>
            <tbody id="bill' . $row["billNo"] . 'Table">';
      for ($i = 0; $i < sizeof($nameArr); $i++) {
        $smallSum = intval($priceArr[$i]) * intval($numArr[$i]);
        echo '<tr><td>' . $nameArr[$i] . '</td><td>' . $priceArr[$i] . '</td><td>' . $numArr[$i] . '</td><td>' . $smallSum . '</td><td>' . $sweetArr[$i] . '</td><td>' . $iceArr[$i] . '</td>';
        if ($noteArr[$i] != null) {
          echo '<td>' . $noteArr[$i] . '</td>';
        } else {
          echo '<td></td>';
        }
        echo '</tr>';
      }

      echo '</tbody>
          </table>
        </div>
      </div>
    </div>
  </div>';
    }
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
