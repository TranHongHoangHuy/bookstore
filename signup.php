<?php
include './conn.php';
require './public/header.php';

// Kiểm tra xem người dùng đã ấn nút đăng ký hay chưa
if (isset($_POST['register'])) {
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
        $stmt = $pdo->prepare('INSERT INTO user (username, password, phone, address, name) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$username, $password, $phone, $address, $name]);

        // Đăng ký thành công, chuyển hướng đến trang đăng nhập
        header('Location: login.php');
        exit;
    }
}


?>


<form method="post" action="signup.php">
    <div class="card_lgi_container">
        <div class="card_lgi">
            <a class="card_lgi_login mt-2">Sign up</a>
            <div class="card_lgi_inputBox">
                <input type="text" required="required" name="name" value="" id="name">
                <span class="user">Name</span>
            </div>
            <div class="card_lgi_inputBox">
                <input type="text" required="required" name="username" value="" id="username">
                <span class="user">Username</span>
            </div>

            <div class="card_lgi_inputBox">
                <input type="password" required="required" name="password" value="" id="password">
                <span>Password</span>
            </div>

            <div class="card_lgi_inputBox">
                <input type="tel" required="required" pattern="[0-9]{10}" name="phone" value="" id="phone">
                <span>Phone number</span>
            </div>

            <div class="card_lgi_inputBox">
                <input type="text" required="required" name="address" value="" id="address">
                <span>Address</span>
            </div>
            <button class="card_lgi_enter" type="submit" name="register" value="Register">Enter</button>
        </div>
    </div>
</form>

<script>
    document.title = "Đăng ký";
</script>
<?php include './public/footer.php'; ?>