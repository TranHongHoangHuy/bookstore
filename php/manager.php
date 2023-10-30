<?php
include '../conn.php';
require './admin_header.php'
?>

<button id="scroll-to-top"><i class="fa-solid fa-arrow-up"></i></button>

<main style="min-height: 800px;">
  <div class="container p-5 bg-dark text-white text-center mt-5 mb-5" style="border-radius: 5px;">
    <h1>Chào mừng người quản trị!</h1>
    <p>Chúc bạn một ngày làm việc thật tốt.</p>
  </div>

  <div class="container text-center">
    <h2>Hãy chọn chức năng</h2>
    <div class="row" style="justify-content: center; align-items: center;">
      <div class="col-lg-4 col-md-6 col-sm-12 card product" style="height: 100px;">
        <a href="./admin_product.php">
          <div class="card-info">
            <p class="text-title">Quản lý sản phẩm</p>
          </div>
        </a>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12 card product" style="height: 100px;">
        <a href="./admin_customer.php">
          <div class="card-info">
            <p class="text-title">Quản lý khách hàng</p>
          </div>
        </a>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12 card product" style="height: 100px;">
        <a href="./admin_orders.php">
          <div class="card-info">
            <p class="text-title">Quản lý đơn hàng</p>
          </div>
        </a>
      </div>
    </div>
  </div>

</main>
<?php include './footer.php'; ?>

<script>
  document.title = "Quan ly";
</script>
</body>

</html>