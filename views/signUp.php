<?php 
session_start();
require("header.php");
?>

<body>
  <div class="container" id="loginPage">
    <center>
      <div class="card card-default" id="loginCard">
        <h1>蟬吃茶點餐機器人</h1>
        <form action="../loginControl.php?act=signUp" method="POST">
          <div class="row">
            <label for="userName">賬戶名稱</label>
            <input type="text" name="userName" required autofocus>
          </div>
          <br>
          <div class="row">
            <label for="passWord">賬戶密碼</label>
            <input type="password" name="passWord" required>
          </div>
          <br>
          <div class="row">
            <label for="passWord">聯絡號碼</label>
            <input type="text" name="phoneNum" required>
          </div>
          <br>
          <div class="error">
            <?php if (isset($_SESSION["failed"])) {
                          if ($_SESSION["failed"] == "suName")
                            echo "<p>名稱重複</p>";
                          if ($_SESSION["failed"] == "signUp")
                            echo "<p>註冊失敗</p>";
                        }  ?>
          </div>
          <button type="submit" class="btn btn-info">註冊</button>
          <button type="button" class="btn" onclick="javascript:location.href='login.php'">返回</button>
        </form>
      </div>
    </center>
  </div>
</body>