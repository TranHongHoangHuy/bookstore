<?php
include '../conn.php';

// Lấy ID của sản phẩm cần xóa từ form POST
$id_order = $_POST['id_order'];

// Thực hiện truy vấn SQL để xóa sản phẩm
$stmt = $pdo->prepare('DELETE FROM hoadon WHERE id_order = :id_order');
$stmt->bindValue(':id_order', $id_order);
$result = $stmt->execute();

// Kiểm tra kết quả và thông báo cho người dùng
if ($result) {
    echo "Đơn hàng có ID $id_order đã được xóa.";
    header('Location: ./admin_orders.php');
} else {
    echo "Có lỗi xảy ra khi xóa đơn hàng có ID $id_order.";
    header('Location: ./admin_orders.php');
}
