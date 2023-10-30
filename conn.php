<?php
// Thông tin kết nối cơ sở dữ liệu
$host = 'localhost';
$dbname = 'bookstore';
$usernamedb = 'root';
$passworddb = '';

// Tạo kết nối PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $usernamedb, $passworddb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Kết nối đến cơ sở dữ liệu $dbname thất bại: " . $e->getMessage();
}
