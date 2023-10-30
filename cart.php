<?php
include './conn.php';
require './php/header.php';

// Kiểm tra xem người dùng đã ấn nút đăng ký hay chưa
if (isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $totalPrice = $_POST['totalAmount'];
    $order_userName = $_POST['name'];
    $order_userPhone = $_POST['phone'];
    $order_userAddress = $_POST['address'];
    $order_notes = $_POST['note'];


    //đưa thông tin sản phẩm vào bảng order
    $stmt = $pdo->prepare('INSERT INTO hoadon (totalPrice, order_userName, order_userPhone, order_userAddress, order_notes) 
    VALUES (:totalPrice, :order_userName, :order_userPhone, :order_userAddress, :order_notes)');

    $stmt->execute([
        ':totalPrice' => $totalPrice,
        ':order_userName' => $order_userName,
        ':order_userPhone' => $order_userPhone,
        ':order_userAddress' => $order_userAddress,
        ':order_notes' => $order_notes
    ]);




    // ấn submit thành công, hiện modal
    echo "<p class='alert alert-success text-center'>Bạn đã mua hàng thành công!!! Cửa hàng đã ghi nhận và sẽ sớm liên hệ với bạn</p>";
    echo '<script>
    localStorage.clear();</script>';
}

?>
<div class="shop-title text-center m-5">
    <h1>Giỏ hàng</h1>
</div>
<div class="container cart_top">
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
            <tr class="text-center">
                <th scope="col" style="width: 70%;">Sản phẩm</th>
                <th scope="col" style="width: 10%;">Đơn giá</th>
                <th scope="col" style="width: 5%;">SL</th>
                <th scope="col" style="width: 10%;">Tổng giá</th>
                <th scope="col" style="width: 5%;"></th>
            </tr>
        </thead>
        <tbody id="cartBody"></tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-start"><strong>Tổng tiền:</strong></td>
                <td id="totalPriceColumn" class="text-end"><strong></strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="shop-form text-center m-5">
    <h2>Thông tin mua hàng</h2>
</div>

<div class="container cart_bottom">
    <form method="post" action="cart.php" id="cart_form">
        <div class="form-row m-4" style="display: flex;">
            <div class="form-group col-md-6 pe-2">
                <input type="text" id="name" name="name" class="form-control" placeholder="Tên">
            </div>

            <div class="form-group col-md-6 ps-2">
                <input type="tel" id="phone" name="phone" class="form-control" placeholder="Số điện thoại">
            </div>
        </div>

        <div class="form-group m-4">
            <input type="text" id="address" name="address" class="form-control" placeholder="Địa chỉ">
        </div>

        <div class="form-group m-4">
            <textarea id="note" name="note" class="form-control" placeholder="Ghi chú (nếu có)"></textarea>
        </div>

        <input type="hidden" name="totalAmount" id="totalAmountInput" value="">

        <div class="form-group m-4">
            <button type="submit" name="submit" class="btn btn-primary" style="width: 100%;">Mua hàng</button>
        </div>
    </form>


</div>

<style>
    .container {
        background: #fff;
        display: flex;
        justify-content: center;
        margin-bottom: 50px;
        width: 1000px;
        min-height: 100px;
        padding: 50px;
        border-radius: 12px;
        box-shadow: 0 24px 80px rgba(0, 0, 0, .07), 0 10.0266px 33.4221px rgba(0, 0, 0, .0503198), 0 5.36071px 17.869px rgba(0, 0, 0, .0417275), 0 3.00517px 10.0172px rgba(0, 0, 0, .035), 0 1.59602px 5.32008px rgba(0, 0, 0, .0282725), 0 0.664142px 2.21381px rgba(0, 0, 0, .0196802);
    }
</style>

<script>
    document.title = "Giỏ hàng";

    var totalAmount = 0;
    // Lấy thông tin từ localStorage
    var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

    // Gọi hàm để hiển thị thông tin sản phẩm trong bảng
    displayProductInfo(cartItems);

    function displayProductInfo(cartItems) {
        // Duyệt qua danh sách sản phẩm trong giỏ hàng
        cartItems.forEach(function(cartItem) {
            // Lấy thông tin sản phẩm từ CSDL bằng Ajax
            getProductInfo(cartItem.productId, cartItem.quantity);
        });
    }

    function getProductInfo(productId, quantity) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var productInfo = JSON.parse(this.responseText);
                // Gọi hàm để hiển thị thông tin sản phẩm trong bảng
                displayRow(productInfo, quantity);
            }
        };
        var pathToGetProductInfo = './php/get_product_info.php';
        xhttp.open('GET', pathToGetProductInfo + '?id_product=' + productId, true);
        xhttp.send();
    }

    function displayRow(productInfo, quantity) {
        // Tính tổng giá
        var totalPrice = productInfo.price * quantity;

        // Thêm giá trị của totalPrice vào tổng tiền
        totalAmount += totalPrice;

        // Hiển thị thông tin trong bảng
        var tableBody = document.getElementById('cartBody');
        var newRow = tableBody.insertRow(tableBody.rows.length);
        newRow.innerHTML = `
            <td>
                <div class="row">
                    <div class="col-sm-2">
                        <a href="product.php?id_product= ${productInfo.id_product}">
                            <img src="${productInfo.image_link}" alt="" class="img-fluid">
                        </a>
                    </div>
                    <div class="col-sm-10"><strong>${productInfo.productName}</strong></div>
                </div>
            </td>
            <td>${productInfo.price.toLocaleString()}đ</td>
            <td>${quantity}</td>
            <td>${totalPrice.toLocaleString()}đ</td>
            <td>
                <button class="btn btn-danger" onclick="deleteItem(${productInfo.id_product})">Xóa</button>
            </td>
        `;
        // Gọi hàm cập nhật tổng tiền
        updateTotalAmount();
    }

    function updateTotalAmount() {
        // Lấy phần tử total price trong DOM
        var totalAmountElement = document.getElementById('totalPriceColumn');

        if (totalAmountElement) {
            // Hiển thị tổng tiền đã tính toán
            totalAmountElement.innerHTML = `<strong>${totalAmount.toLocaleString()}đ</strong>`;
            // totalAmountElement.innerHTML = `<strong>${number_format(totalAmount, 0, '.', '.')}đ</strong>`;
            // Cập nhật giá trị vào trường ẩn
            document.getElementById('totalAmountInput').value = totalAmount;
        }

    }

    function deleteItem(productId) {
        // Lấy thông tin từ localStorage
        var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

        // Xác định vị trí của sản phẩm trong giỏ hàng
        var productIndex = cartItems.findIndex(item => item.productId === productId);

        if (productIndex !== -1) {
            // Lấy số lượng sản phẩm bị xóa để tính toán tổng giá
            var quantityDeleted = cartItems[productIndex].quantity;

            // Trừ giá trị của sản phẩm bị xóa từ tổng tiền
            totalAmount -= quantityDeleted * cartItems[productIndex].price; // Giả sử có trường price trong cartItems

            // Xóa sản phẩm khỏi mảng cartItems
            cartItems.splice(productIndex, 1);

            // Cập nhật lại localStorage
            localStorage.setItem('cartItems', JSON.stringify(cartItems));

            // Xóa toàn bộ thông tin trên bảng
            clearCartDisplay();

            // Cập nhật lại tổng tiền sau khi xóa sản phẩm
            updateTotalAmount();

            // Hiển thị lại giỏ hàng trên trang
            displayProductInfo(cartItems);

            // Làm mới trang
            location.reload();

        } else {
            alert('Sản phẩm không tồn tại trong giỏ hàng.');
        }
    }

    function clearCartDisplay() {
        // Xóa nội dung của tbody trong bảng giỏ hàng
        var tableBody = document.getElementById('cartBody');
        tableBody.innerHTML = '';
    }


    //jquery validate
    $(document).ready(function() {
        $("#cart_form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                phone: {
                    required: true,
                    minlength: 10
                },
                address: "required"
            },
            messages: {
                name: {
                    required: "Bạn chưa nhập tên",
                    minlength: "Tên phải có ít nhất 2 ký tự"
                },
                phone: {
                    required: "Bạn chưa nhập số điện thoại",
                    minlength: "Số điện thoại phải có ít nhất 10 số"
                },
                address: "Bạn chưa nhập địa chỉ"
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.siblings("label"));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            }
        })
    });
</script>


<?php include './php/footer.php'; ?>