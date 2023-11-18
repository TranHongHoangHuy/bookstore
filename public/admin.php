<?php

include '../conn.php';


// Xử lý form đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Lấy giá trị nhập từ form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Truy vấn bảng user để kiểm tra thông tin đăng nhập
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin WHERE username = ? AND password = ?");
  $stmt->execute([$username, $password]);
  $count = $stmt->fetchColumn();

  if ($count > 0) {
    // Lưu session nếu thông tin đăng nhập đúng
    $_SESSION['admin'] = $username;

    // Chuyển hướng đến trang quan ly
    header('Location: ./manager.php');
    exit;
  } else {
    // Hiển thị thông báo nếu thông tin đăng nhập sai
    echo "<script>alert('Bạn đã nhập sai thông tin đăng nhập');</script>";
  }
}
?>
<style media="screen">
  *,
  *:before,
  *:after {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
  }

  body {
    background-color: #080710;
  }

  .background {
    width: 430px;
    height: 520px;
    position: absolute;
    transform: translate(-50%, -50%);
    left: 50%;
    top: 50%;
  }

  .background .shape {
    height: 200px;
    width: 200px;
    position: absolute;
    border-radius: 50%;
  }

  .shape:first-child {
    background: linear-gradient(#1845ad,
        #23a2f6);
    left: -80px;
    top: -80px;
  }

  .shape:last-child {
    background: linear-gradient(to right,
        #ff512f,
        #f09819);
    right: -30px;
    bottom: -80px;
  }

  form {
    height: 520px;
    width: 400px;
    background-color: rgba(255, 255, 255, 0.13);
    position: absolute;
    transform: translate(-50%, -50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
    padding: 50px 35px;
  }

  form * {
    font-family: 'Poppins', sans-serif;
    color: #ffffff;
    letter-spacing: 0.5px;
    outline: none;
    border: none;
  }

  form h3 {
    font-size: 32px;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
  }

  label {
    display: block;
    margin-top: 30px;
    font-size: 16px;
    font-weight: 500;
  }

  input {
    display: block;
    height: 50px;
    width: 100%;
    background-color: rgba(255, 255, 255, 0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 14px;
    font-weight: 300;
  }

  ::placeholder {
    color: #e5e5e5;
  }

  button {
    margin-top: 50px;
    width: 100%;
    background-color: #ffffff;
    color: #080710;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
  }

  button:hover {
    background-color: #e3e3e3;
    color: #080710;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
  }

  .social {
    margin-top: 30px;
    display: flex;
  }

  .social div {
    background: red;
    width: 150px;
    border-radius: 3px;
    padding: 5px 10px 10px 5px;
    background-color: rgba(255, 255, 255, 0.27);
    color: #eaf0fb;
    text-align: center;
  }

  .social div:hover {
    background-color: rgba(255, 255, 255, 0.47);
  }

  .social .fb {
    margin-left: 25px;
  }

  .social i {
    margin-right: 4px;
  }

  a {
    text-decoration: none;
  }
</style>
<div class="background">
  <div class="shape"></div>
  <div class="shape"></div>
</div>
<form method="post" action="manager.php">
  <h3>Đăng Nhập Quản Lý</h3>

  <label for="username">Username</label>
  <input type="text" placeholder="Tên đăng nhập" id="username" name="username">

  <label for="password">Password</label>
  <input type="password" placeholder="Mật khẩu" id="password" name="password">

  <button type="submit">Đăng Nhập</button>
  <div class="social">
    <a href="../index.php">
      <div class="go">Trang chủ</div>
    </a>
    <div class="fb">Liên hệ</div>
  </div>
</form>