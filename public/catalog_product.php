<?php
include '../conn.php';
require './header.php';

if (isset($_GET['id_catalog'])) {
    // Lấy giá trị id_catalog từ URL
    $id_catalog = $_GET['id_catalog'];

    // Truy vấn SQL để lấy danh sách sản phẩm của thể loại tương ứng
    $stmt = $pdo->prepare('SELECT product.*, catalog.catalogName 
                       FROM product 
                       JOIN catalog ON product.id_catalog = catalog.id_catalog
                       WHERE product.id_catalog = :id_catalog');

    $stmt->execute([':id_catalog' => $id_catalog]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //xử lý phân trang
    // Số lượng bản ghi hiển thị trên mỗi trang
    $limit = 8;

    // Tính tổng số trang
    $totalPages = ceil(count($products) / $limit);

    // Xác định trang hiện tại
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Xác định vị trí bắt đầu của trang hiện tại
    $paginationStart = ($page - 1) * $limit;

    // Lấy chỉ mục của mảng bắt đầu từ $paginationStart và có độ dài $limit
    $currentPageProducts = array_slice($products, $paginationStart, $limit);

?>
    <!-- // Hiển thị kết quả tìm kiếm -->
    <main>
        <div class="container">

            <!-- Product -->
            <div class="text-center">
                <div>
                    <h1 class='text-search-result'>Danh mục: <?php echo $products[0]['catalogName']; ?></h1>
                </div>
                <div id="gallery" class="row">
                    <?php foreach ($currentPageProducts as $product) { ?>
                        <div class="col-lg-2 col-md-3 col-sm-6 card product">
                            <a href="../product.php?id_product=<?php echo $product['id_product']; ?>">
                                <div class="card-img">
                                    <?php if (!empty($product['image_link'])) : ?>
                                        <!-- Sử dụng đường dẫn từ trường image_link -->
                                        <img src="<?php echo $product['image_link']; ?>" alt="">
                                    <?php else : ?>
                                        <!-- Sử dụng đường dẫn cục bộ khi tải ảnh lên -->
                                        <img src="../assets/img/upload/<?php echo basename($product['image_path']); ?>" alt="">
                                    <?php endif; ?>
                                </div>
                            </a>
                            <div class="card-info">
                                <p class="text-title productTitle"><?php echo $product['productName']; ?></p>

                            </div>
                            <div class="card-footer">
                                <span class="text-title"><?php echo number_format($product['price'], 0, '.', '.'); ?>đ</span>
                                <div class="card-button" onclick="getInfo(this)">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!--End Product -->
            <!-- pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1) : ?>
                        <li class="page-item"><a class="page-link" href="?id_catalog=<?= $id_catalog ?>&page=<?= $page - 1 ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>"><a class="page-link" href="?id_catalog=<?= $id_catalog ?>&page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages) : ?>
                        <li class="page-item"><a class="page-link" href="?id_catalog=<?= $id_catalog ?>&page=<?= $page + 1 ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <!--end pagination -->
        </div>
    </main>

    <script>
        // JavaScript để cắt văn bản và thêm dấu "..."
        var titleElements = document.getElementsByClassName("productTitle");
        var maxLength = 35; // Độ dài tối đa
        for (var i = 0; i < titleElements.length; i++) {
            var titleElement = titleElements[i];
            var titleText = titleElement.innerText;

            if (titleText.length > maxLength) {
                titleElement.innerText = titleText.substring(0, maxLength) + "...";
            }
        }

        // Lấy thông tin từ localStorage
        var cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];

        // Tính tổng số lượng sản phẩm trong giỏ hàng
        var totalQuantity = cartItems.reduce(function(total, item) {
            return total + parseInt(item.quantity);
        }, 0);

        // Hiển thị số lượng sản phẩm trong giao diện
        document.getElementById("cartItemCount").innerText = totalQuantity;
    </script>
<?php
}

?>
<?php include './footer.php'; ?>