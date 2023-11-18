<?php
include './conn.php';
require './public/header.php';

$products = $pdo->query("SELECT * FROM product WHERE id_catalog = 1 ORDER BY RAND() LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

$id_product = $_GET['id_product'];

// Lấy thông tin sản phẩm từ bảng product
$stmt = $pdo->prepare('SELECT * FROM product WHERE id_product = :id_product');
$stmt->execute([':id_product' => $id_product]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<main>
    <div class="top">
        <div class="container product">
            <div class="row product_detail ">

                <div class="col-lg-6 product_detail_a">

                    <img src="<?php echo $product['image_link']; ?>" alt="">

                </div>

                <div class="col-lg-6 product_detail_b">
                    <h2 class="name">
                        <?php echo $product['productName']; ?>
                    </h2>
                    <h4 class="price"><?php echo number_format($product['price'], 0, '.', '.'); ?>đ</h4>

                    <h6 class="producCode">Mã sách: <?php echo $product['productCode'] ?></h6>
                    <h6 class="ISBN">Mã ISBN: <?php echo $product['ISBN'] ?></h6>
                    <h6 class="pageNumber">Số trang: <?php echo $product['pageNumber'] ?></h6>
                    <h6 class="author">Tác giả:
                        <a href="search.php?keyword=<?php echo urlencode($product['author']); ?>">
                            <?php echo $product['author']; ?>
                        </a>
                    </h6>
                    <h6>Số lượng:</h6>
                    <div class="quantity-selector">
                        <button class="btn btn-primary quantity-btn" onclick="decrement()">-</button>
                        <input type="text" class="form-control quantity-input" value="1" id="quantity">
                        <button class="btn btn-primary quantity-btn" onclick="increment()">+</button>
                    </div>
                    <button type="submit" class="btn btn-primary " onclick="addToCart(<?php echo $product['id_product']; ?>)"><strong>Mua hàng</strong></button>
                    <ul class="product-list">
                        <li><i class="fa fa-truck"></i> Giao hàng nhanh toàn quốc <a href="#">Xem chi tiết</a></li>
                        <li><i class="fa fa-phone"></i> Tổng đài: 1900.9696.42 (9h00 - 21h00 mỗi ngày)</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <div class="bottom">
        <div class="container">
            <div class="row">
                <!-- Info -->
                <div class="col-lg-12 product-info">
                    <div class="product-info-btn">
                        <button type="button" class="description-button"><span>Mô tả</span></button>
                    </div>
                    <div class="product-info-content" style="color: black;">
                        <div id="description-content">
                            <p><?php echo $product['content']; ?></p>
                        </div>
                    </div>
                </div>

                <!-- Recomment -->
                <div class="col-lg-12 product-recomment">
                    <div class="product-info-btn">
                        <button type="button" class="description-button"><span>Đề xuất truyện</span></button>
                    </div>
                    <!-- Slide -->
                    <div class="product-recomment-slide">
                        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($products as $key => $product) : ?>
                                    <div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>" data-bs-interval="5000">
                                        <div class="text-center">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-3 col-sm-6 card product">
                                                    <a href="product.php?id_product=<?php echo $product['id_product']; ?>">
                                                        <div class="card-img">
                                                            <img src="<?php echo $product['image_link']; ?>" alt="">
                                                        </div>
                                                    </a>
                                                    <div class="card-info">
                                                        <p class="text-title productTitle"><?php echo $product['productName']; ?></p>
                                                    </div>
                                                    <div class="card-footer">
                                                        <span class="text-title"><?php echo number_format($product['price'], 0, '.', '.'); ?>đ</span>
                                                        <button type="submit" class="card-button" onclick="getInfo(this)">
                                                            <i class="fa-solid fa-cart-shopping"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <!-- Slide End -->
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal" id="successModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Sản phẩm đã được thêm vào giỏ hàng.
                </div>
            </div>
        </div>
    </div>
</main>


<script>
    document.title = "San pham";

    let items = document.querySelectorAll('.carousel .carousel-item')

    items.forEach((el) => {
        const minPerSlide = 4
        let next = el.nextElementSibling
        for (var i = 1; i < minPerSlide; i++) {
            if (!next) {
                // wrap carousel by using first child
                next = items[0]
            }
            let cloneChild = next.cloneNode(true)
            el.appendChild(cloneChild.children[0])
            next = next.nextElementSibling
        }
    })

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

    //Thêm sản phẩm
    function addToCart(productId) {
        // Lấy số lượng từ ô input
        var quantity = document.getElementById('quantity').value;

        // Kiểm tra xem đã lưu thông tin giỏ hàng trước đó chưa
        var cartItems = localStorage.getItem('cartItems');
        if (!cartItems) {
            // Nếu chưa có thông tin giỏ hàng, tạo một mảng mới
            cartItems = [];
        } else {
            // Nếu đã có thông tin giỏ hàng, chuyển đổi từ JSON sang mảng
            cartItems = JSON.parse(cartItems);

            // Kiểm tra xem sản phẩm với id_product đã tồn tại trong giỏ hàng hay chưa
            var existingProductIndex = cartItems.findIndex(item => item.productId === productId);

            if (existingProductIndex !== -1) {
                // Nếu sản phẩm đã tồn tại, cập nhật số lượng
                cartItems[existingProductIndex].quantity = parseInt(cartItems[existingProductIndex].quantity) + parseInt(quantity);
            } else {
                // Nếu sản phẩm chưa tồn tại, thêm sản phẩm mới vào giỏ hàng
                cartItems.push({
                    productId: productId,
                    quantity: quantity
                });
            }
        }

        // Lưu thông tin giỏ hàng vào localStorage
        localStorage.setItem('cartItems', JSON.stringify(cartItems));

        // Log nội dung của localStorage ra console để kiểm tra
        console.log('LocalStorage Content:', localStorage.getItem('cartItems'));

        // alert('Đã thêm sản phẩm vào giỏ hàng thành công!');
        $('#successModal').modal('show');
        setTimeout(function() {
            $('#successModal').modal('hide');
        }, 2000);
    }
</script>
<?php include './public/footer.php'; ?>