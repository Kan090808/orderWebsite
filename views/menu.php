<?php
require_once("../model/model.php");
?>
<div class="row">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#menuPic">菜單照片</a></li>
    <li><a data-toggle="tab" href="#searchMenu">搜尋商品</a></li>
  </ul>

  <div class="tab-content">
    <div id="menuPic" class="tab-pane fade in active">
      <img src="../img/menu.jpg">
    </div>
    <div id="searchMenu" class="tab-pane fade">
      <div class="row">
        <h3>搜尋關鍵字：</h3>
        <div class="col-md-3">
          <input type="text" class="form-control" id="searchStr">
        </div>

      </div>
      <div class=" row">
        <h3>搜尋系列：</h3>
        <?php seriesBtn(); ?>
      </div>
      <div class="row">
        <?php showMenu(); ?>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  $(".btn-series").click(function() {
    var str = $(this).attr("id");
    $("#menuTable tr").filter(function() {
      $(this).toggle($(this).text().indexOf(str) > -1);
    });
  });

  $("#searchStr").on("keyup", function() {
    var str = $(this).val();
    $("#menuTable tr").filter(function() {
      $(this).toggle($(this).text().indexOf(str) > -1);
    });
  });
});
</script>