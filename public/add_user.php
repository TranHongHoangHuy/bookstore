<?php
include '../conn.php';
// Nếu form đã submit, thực hiện lưu thông tin sản phẩm vào CSDL
if (isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $name = $_POST['name'];

    // Kiểm tra xem username đã được sử dụng hay chưa
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM user WHERE username = ?');
    $stmt->execute([$username]);

    if ($stmt->fetchColumn() > 0) {
        // Username đã được sử dụng, hiển thị thông báo lỗi
        echo 'Username already exists.';
    } else {
        // Thêm người dùng vào CSDL
        $stmt = $pdo->prepare('INSERT INTO user (username, password, phone, address, name) 
        VALUES (:username, :password, :phone, :address, :name)');
        $stmt->execute([
            ':username' => $username,
            ':password' => $password,
            ':phone' => $phone,
            ':address' => $address,
            ':name' => $name
        ]);

        // Hiển thị thông báo thành công và xóa thông tin trong form
        echo "<p class='alert alert-success'>Thêm khách hàng thành công</p>";
        $_POST = array();
    }
}

?>
<?php
require './admin_header.php'
?>
<div class="container">
    <h1>Thêm khách hàng mới</h1>
    <form method="post" action="">
        <div class="form-group">
            <label for="username">username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập pass" required>
        </div>
        <div class="form-group">
            <label for="phone">SĐT</label>
            <input type="tel" class="form-control" pattern="[0-9]{10}" id="phone" name="phone" placeholder="Nhập SĐT" required>
        </div>
        <div class="form-group">
            <label for="address">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ">
        </div>
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Thêm khách hàng</button>
    </form>
</div>
<script>
    document.title = "Them khach hang";
</script>
</body>

</html>