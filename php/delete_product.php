<?php
include '../conn.php';

// Lấy ID của sản phẩm cần xóa từ form POST
$id_product = $_POST['id_product'];

// Thực hiện truy vấn SQL để xóa sản phẩm
// $sql = "DELETE FROM product WHERE id_product = :id_product";
$stmt = $pdo->prepare('DELETE FROM product WHERE id_product = :id_product');
$stmt->bindValue(':id_product', $id_product);
$result = $stmt->execute();

// Kiểm tra kết quả và thông báo cho người dùng
if ($result) {
    echo "Sản phẩm có ID $id_product đã được xóa.";
    header('Location: ./admin_product.php');
} else {
    echo "Có lỗi xảy ra khi xóa sản phẩm có ID $id_product.";
    header('Location: ./admin_product.php');
}
