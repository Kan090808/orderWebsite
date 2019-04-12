<?php
session_start();
if (!isset($_SESSION["login"]))
  header("location:login.php");
require("header.php");
?>

<body data-spy="scroll" data-target=".navbar" data-offset="50">
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand">蟬吃茶點餐機器人</a>
      </div>

      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li id="homepage"><a href="#">首頁</a></li>
          <li id="order"><a href="#">點餐</a></li>
          <li id="intro"><a href="#">產品介紹</a></li>
          <li id="menu"><a href="#">菜單</a></li>
          <li id="history"><a href="#">歷史訂單</a></li>
          <li id="chat"><a href="#">咨詢服務</a></li>
          <li id="contact"><a href="#">聯絡我們</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="control.php?act=logout"><span class="glyphicon glyphicon-log-in"></span>登出</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container" id="content">
  </div>
</body>

</html>