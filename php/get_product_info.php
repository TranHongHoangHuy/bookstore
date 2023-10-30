<?php
include '../conn.php';

if (isset($_GET['id_product'])) {
    $id_product = $_GET['id_product'];

    try {
        $stmt = $pdo->prepare('SELECT * FROM product WHERE id_product = :id_product');
        $stmt->execute([':id_product' => $id_product]);
        $productInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        // Trả về dữ liệu dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($productInfo);
    } catch (PDOException $e) {
        // Xử lý lỗi nếu có
        echo 'Lỗi truy vấn CSDL: ' . $e->getMessage();
    }
} else {
    echo 'Thiếu tham số id_product';
}
