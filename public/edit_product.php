<?php
include '../conn.php';
require './admin_header.php';

// Lấy ID của sản phẩm cần xóa từ form POST
$id_product = $_POST['id_product'];

// Kiểm tra submit
if (isset($_POST['submit'])) {
    // Lấy thông tin sản phẩm từ form
    $id_product = $_POST['id_product'];
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $image_link = $_POST['image_link'];
    $productCode = $_POST['productCode'];
    $ISBN = $_POST['ISBN'];
    $author = $_POST['author'];
    $pageNumber = $_POST['pageNumber'];
    $content = $_POST['content'];

    // Xử lý tập tin ảnh
    $uploadDir = '../assets/img/upload/';
    $uploadFile = $uploadDir . basename($_FILES['uploadImage']['name']);

    // Kiểm tra xem có ảnh mới được tải lên không
    if (!empty($_FILES['uploadImage']['tmp_name']) && is_uploaded_file($_FILES['uploadImage']['tmp_name'])) {
        // Xóa ảnh cũ (nếu có)
        if (!empty($image_link)) {
            unlink($image_link);
        }

        // Di chuyển ảnh mới đến thư mục upload
        move_uploaded_file($_FILES['uploadImage']['tmp_name'], $uploadFile);
        $imagePath = $uploadFile;
        $imageLink = '';
    } else {
        $imagePath = '';
        $imageLink = $_POST['image_link'];
    }

    // Cập nhật thông tin sách vào CSDL
    $stmt = $pdo->prepare('UPDATE product SET 
        productName = :productName,
        price = :price,
        image_link = :image_link,
        image_path = :image_path,
        productCode = :productCode,
        ISBN = :ISBN,
        pageNumber = :pageNumber,
        author = :author,
        content = :content
        WHERE id_product = :id_product');

    $stmt->execute([
        ':productName' => $productName,
        ':price' => $price,
        ':image_link' => $image_link,
        ':image_path' => $imagePath,
        ':productCode' => $productCode,
        ':ISBN' => $ISBN,
        ':pageNumber' => $pageNumber,
        ':author' => $author,
        ':content' => $content,
        ':id_product' => $id_product
    ]);

    // Chuyển hướng sau khi cập nhật thành công (có thể điều hướng đến trang chi tiết sách hoặc trang danh sách sách)
    header('Location: ./admin_product.php');
    exit;
}

// Lấy thông tin sản phẩm từ bảng product
$stmt = $pdo->prepare('SELECT * FROM product WHERE id_product = :id_product');
$stmt->execute([':id_product' => $id_product]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<div class="container">
    <h1>Chỉnh sửa sách</h1>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group" style="display:none;">
            <label for="productName">id_product</label>
            <input type="text" class="form-control" id="id_product" name="id_product" value="<?= htmlspecialchars($product['id_product']) ?>">
        </div>
        <div class="form-group">
            <label for="productName">Tên sách:</label>
            <input type="text" class="form-control" id="productName" name="productName" value="<?= htmlspecialchars($product['productName']) ?>">
        </div>
        <div class="form-group">
            <label for="price">Giá sách:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>">
        </div>
        <div class="form-group">
            <label for="image_link">Link ảnh:</label>
            <input type="text" class="form-control" id="image_link" name="image_link" value="<?= htmlspecialchars($product['image_link']) ?>">
            <label for="formFile" class="form-label">Tải ảnh lên</label>
            <input class="form-control" type="file" id="uploadImage" name="uploadImage" onchange="previewImage(this)">
        </div>
        <img id="preview" style="max-width: 100%; margin-top: 10px; display: none;">
        <div class="form-group">
            <label for="content">Mã sách:</label>
            <input type="text" class="form-control" id="productCode" name="productCode" value="<?= htmlspecialchars($product['productCode']) ?>"></input>
        </div>
        <div class="form-group">
            <label for="content">ISBN:</label>
            <input type="text" class="form-control" id="ISBN" name="ISBN" value="<?= htmlspecialchars($product['ISBN']) ?>"></input>
        </div>
        <div class="form-group">
            <label for="content">Tên tác giả:</label>
            <input type="text" class="form-control" id="author" name="author" value="<?= htmlspecialchars($product['author']) ?>"></input>
        </div>
        <div class="form-group">
            <label for="content">Số trang:</label>
            <input type="text" class="form-control" id="pageNumber" name="pageNumber" value="<?= htmlspecialchars($product['pageNumber']) ?>"></input>
        </div>
        <div class="form-group">
            <label for="content">Mô tả:</label>
            <textarea class="form-control" id="content" name="content" rows="10"><?= htmlspecialchars($product['content']) ?></textarea>

        </div>
        <button type="submit" name="submit" class="btn btn-primary mt-2">Sửa sách</button>
    </form>
</div>
<script>
    document.title = "Sua san pham";

    function previewImage(input) {
        var preview = document.getElementById('preview');
        var uploadImage = document.getElementById('uploadImage');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>
</body>

</html>