<?php
include '../conn.php';
// Nếu form đã submit, thực hiện lưu thông tin sản phẩm vào CSDL
if (isset($_POST['submit'])) {
    // Lấy thông tin sản phẩm từ form
    $id_catalog = $_POST['id_catalog'];
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $image_link = $_POST['image_link'];
    $productCode = $_POST['productCode'];
    $ISBN = $_POST['ISBN'];
    $pageNumber = $_POST['pageNumber'];
    $author = $_POST['author'];
    $content = $_POST['content'];

    // Chuẩn bị câu truy vấn SQL để thêm sản phẩm vào CSDL
    $stmt = $pdo->prepare('INSERT INTO product (id_catalog, productName, price, image_link, content, productCode, ISBN, pageNumber, author) 
    VALUES (:id_catalog, :productName, :price, :image_link, :content, :productCode, :ISBN, :pageNumber, :author)');

    // Thực hiện truy vấn SQL với thông tin sản phẩm vừa lấy từ form
    $stmt->execute([
        ':id_catalog' => $id_catalog,
        ':productName' => $productName,
        ':price' => $price,
        ':image_link' => $image_link,
        ':productCode' => $productCode,
        ':pageNumber' => $pageNumber,
        ':author' => $author,
        ':ISBN' => $ISBN,
        ':content' => $content
    ]);

    // Hiển thị thông báo thành công và xóa thông tin trong form
    echo "<p class='alert alert-success'>Thêm sản phẩm thành công</p>";
    $_POST = array();
}
// Lấy thông tin danh mục sản phẩm để hiển thị trong form
$catalogs = $pdo->query("SELECT * FROM catalog")->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
require './admin_header.php'
?>
<div class="container">
    <h1>Thêm sách mới</h1>
    <form method="post" action="">
        <div class="form-group">
            <label for="id_catalog">Danh mục sách:</label>
            <select class="form-control" id="id_catalog" name="id_catalog">
                <?php foreach ($catalogs as $catalog) : ?>
                    <option value="<?= $catalog['id_catalog'] ?>"><?= $catalog['catalogName'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="productName">Tên sách:</label>
            <input type="text" class="form-control" id="productName" name="productName" placeholder="Nhập tên sách" required>
        </div>
        <div class="form-group">
            <label for="price">Giá sách:</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="Nhập giá" required>
        </div>
        <div class="form-group">
            <label for="image_link">Link ảnh:</label>
            <input type="text" class="form-control" id="image_link" name="image_link" placeholder="Nhập link ảnh" required>
        </div>
        <div class="form-group">
            <label for="content">Mã sách:</label>
            <textarea class="form-control" id="productCode" name="productCode" placeholder="Nhập mã" required></textarea>
        </div>
        <div class="form-group">
            <label for="content">ISBN:</label>
            <textarea class="form-control" id="ISBN" name="ISBN" placeholder="Nhập ISBN" required></textarea>
        </div>
        <div class="form-group">
            <label for="content">Tên tác giả:</label>
            <textarea class="form-control" id="author" name="author" placeholder="Nhập tên tác giả" required></textarea>
        </div>
        <div class="form-group">
            <label for="content">Số trang:</label>
            <textarea class="form-control" id="pageNumber" name="pageNumber" placeholder="Nhập số trang" required></textarea>
        </div>
        <div class="form-group">
            <label for="content">Mô tả:</label>
            <textarea class="form-control" id="content" name="content" rows="5" placeholder="Nhập mô tả" required></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Thêm sách</button>
    </form>
</div>

<script>
    document.title = "Them san pham";
</script>
</body>

</html>