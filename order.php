<?php require("model.php"); ?>


<div class="row">
  <div class="col-md-8">
    <div class="row">
      <h1>購物車</h1>
    </div>
    <div class="row">
      <form action="control.php?act=confirmCart" method="POST">
        <div class="col-md-3 col-xs-12">
          <h3>共計：<?php echo getTotal(); ?>元</h3>
        </div>
        <div class="col-md-3 col-xs-5 ">
          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-primary btn-downer active">
              <input type="radio" name="type" id="自取" autocomplete="off" value="自取" checked>自取
            </label>
            <label class="btn btn-primary btn-downer">
              <input type="radio" name="type" id="外送" autocomplete="off" value="外送"> 外送
            </label>

          </div>
        </div>
        <div class="col-md-6 col-xs-7">
          <button type="submit" class="btn btn-success btn-downer">確認訂單</button>
          <button type="button" onclick="javascript:location='control.php?act=clearCart'"
            class="btn btn-danger btn-downer">清除購物車</button>
        </div>
      </form>
    </div>
    <div class="row">
      <div class="table-responsive">
        <table class="table table-striped" id="cartTable"">
        
          <?php showCart(); ?>

            </table>
        </div>
    </div>
  </div>
  <div class=" col-md-4">
          <h1>點餐</h1>
          <div class="row">
            <?php seriesBtn(); ?>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-striped">
              <tbody id="seriesTable">
                <?php showbySeries(); ?>
              </tbody>
            </table>
          </div>
      </div>
      <div class="modal fade" id="productSelected" role="dialog">
        <div class="modal-dialog modal-sm">
          <form id="selectedForm" action="control.php?act=addtoCart" method="POST">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 id="selectedName"></h3>
                <input type="hidden" name="addtoName" id="addtoName">
              </div>
              <div class="modal-body">
                <div class="container-fluid">

                  <div class="row">
                    <div class="col-md-4">
                      <label for="size">大小：</label>

                    </div>
                    <div class="col-md-8">
                      <select id="selectedSize" class="form-control" name="addtoSize">

                      </select>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label>單價:</label>
                    </div>
                    <div class="col-md-8">
                      <input type="num" id="selectedPrice" class="form-control" disabled>
                      <input type="hidden" id="addtoPrice" name="addtoPrice">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label>數量:</label>
                    </div>
                    <div class="col-md-8">
                      <div class="input-group">
                        <span class="input-group-addon" id="minus">-</span>
                        <input id="num" type="number" class="form-control" value="1" min="1" name="addtoNum">
                        <span class="input-group-addon" id="add">+</span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label for="selectedSweet">甜度：</label>

                    </div>
                    <div class="col-md-8">
                      <select id="selectedSweet" class="form-control" name="addtoSweet">
                        <option value="正常">正常</option>
                        <option value="少糖">少糖</option>
                        <option value="半糖">半糖</option>
                        <option value="微糖">微糖</option>
                        <option value="無糖">無糖</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label for="selectedIce">冰塊：</label>

                    </div>
                    <div class="col-md-8">
                      <select id="selectedIce" class="form-control" name="addtoIce">
                        <option value="正常">正常</option>
                        <option value="少冰">少冰</option>
                        <option value="去冰">去冰</option>
                        <option value="溫飲">溫飲</option>
                        <option value="熱飲">熱飲</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label for="selectedNote">備註：</label>
                    </div>
                    <div class="col-md-8">
                      <textarea class="form-control" rows="2" id="selectedNote" name="addtoNote"></textarea>
                    </div>
                  </div>
                  <div class="row">
                    <input type="submit" class="btn btn-success" value="加入" id="modalSubmit">
                    <button type="button" class="btn" data-dismiss="modal">取消</button>
                  </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>



<script>
// table search
$(document).ready(function() {

  $(" #seriesTable tr").filter(function() {
    $(this).toggle(null);
  });

  $(".btn-series").click(function() {
    var str = $(this).attr("id");
    $("#seriesTable tr").filter(function() {
      $(this).toggle($(this).text().indexOf(str) > -1);
    });
  });
  $(".select-btn").click(function() {
    $.post("control.php?act=selectProduct", {
      productName: $(this).attr("id")
    }, function(data) {
      productName = JSON.parse(data)[0];
      productSize = JSON.parse(data)[1];
      productPrice = JSON.parse(data)[2];
      $("#selectedName").html(productName[0]);
      $("#addtoName").val(productName[0]);
      $("#selectedSize").html("");
      $("#selectedForm #num").val("1");
      for (var i = 0; i < productSize.length; i++) {
        $("#selectedSize").append("<option value='" + productSize[i] + "'>" + productSize[i] + "</option>");
      }
      $("#selectedPrice").val(productPrice[0]);
      $("#addtoPrice").val(productPrice[0]);
      $("#productSelected").modal("show");
    })
  });
  $(".edit-btn").click(function() {
    $.post("control.php?act=editProduct", {
      productName: $(this).attr("id")
    }, function(data) {
      productName = JSON.parse(data)[0];
      productSize = JSON.parse(data)[1];
      nowSize = JSON.parse(data)[2];
      productPrice = JSON.parse(data)[3];
      productNum = JSON.parse(data)[4];
      productSweet = JSON.parse(data)[5];
      productIce = JSON.parse(data)[6];
      productNote = JSON.parse(data)[7];
      id = JSON.parse(data)[8];
      $("#selectedName").html(productName);
      $("#addtoName").val(productName);
      $("#selectedSize").html("");
      for (var i = 0; i < productSize.length; i++) {
        var options = "<option value='" + productSize[i] + "'";
        if (productSize[i] == nowSize) {
          options = options + "selected='selected'";
          $("#selectedPrice").val(productPrice[i]);
          $("#addtoPrice").val(productPrice[i]);
        }
        $("#selectedSize").append(options + "'>" + productSize[i] + "</option>");
      }
      $("#selectedForm #num").val(productNum);
      $(
        "#selectedSweet").val(productSweet);
      $("#selectedIce").val(productIce);
      $("#selectedNote").val(productNote);
      $("#modalSubmit").val("修改");
      $("#selectedForm").attr("action", "control.php?act=edittoCart&productId=" + id);
      $("#productSelected").modal("show");
    });
  });

  $("#add").click(function() {
    $("#num").val(parseInt($("#num").val()) + 1);
  });

  $("#minus").click(function() {
    if (parseInt($("#num").val()) > 1)
      $("#num").val(parseInt($("#num").val()) - 1);
  });

  $("#selectedSize").change(function() {
    for (var i = 0; i < productSize.length; i++) {
      if ($(this).val() == productSize[i]) {
        $("#selectedPrice").val(productPrice[i]);
        $("#addtoPrice").val(productPrice[i]);
      }
    }
  });

  $(".cartproName").click(function() {
    str = $(this).attr("name");
    $("#seriesTable tr").filter(function() {
      $(this).toggle($(this).text().indexOf(str) > -1);
    });
  })
});
</script>