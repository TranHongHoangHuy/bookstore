<?php
include '../conn.php';

// Lấy ID của user cần xóa từ form POST
$id_user = $_POST['id_user'];

// Thực hiện truy vấn SQL để xóa user
// $sql = "DELETE FROM user WHERE id_user = :id_user";
$stmt = $pdo->prepare('DELETE FROM user WHERE id_user = :id_user');
$stmt->bindValue(':id_user', $id_user);
$result = $stmt->execute();

// Kiểm tra kết quả và thông báo cho người dùng
if ($result) {
    echo "Người dùng có ID $id_user đã được xóa.";
    header('Location: ./admin_customer.php');
} else {
    echo "Có lỗi xảy ra khi xóa sản phẩm có ID $id_user.";
    header('Location: ./admin_customer.php');
}
