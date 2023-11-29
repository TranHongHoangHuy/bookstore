<?php
include '../conn.php';

// Lấy ID của đơn hàng cần sửa từ form POST
$id_order = $_POST['id_order'];
$order_detail = $pdo->query("SELECT chitiet_hoadon.*, product.* FROM chitiet_hoadon
                            INNER JOIN product ON chitiet_hoadon.id_product = product.id_product
                            WHERE chitiet_hoadon.id_order = $id_order")->fetchAll(PDO::FETCH_ASSOC);

?>
<?php
require './admin_header.php'
?>

<main>
    <div class="container mt-5 mb-5">
        <h1 class="text-center">Chi tiết đơn hàng</h1>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_detail as $product) : ?>
                    <tr>
                        <?php if (!empty($product['image_link'])) : ?>
                            <!-- Sử dụng đường dẫn từ trường image_link -->
                            <td><img src="<?php echo $product['image_link']; ?>" style="height: 100px;"></td>
                        <?php else : ?>
                            <!-- Sử dụng đường dẫn cục bộ khi tải ảnh lên -->
                            <td><img src="../assets/img/upload/<?php echo basename($product['image_path']); ?>" style="height: 100px;"></td>
                        <?php endif; ?>
                        <td class="td-center"><?php echo $product['productName']; ?></td>
                        <td class="td-center"><?php echo $product['quantity']; ?></td>
                        <td class="td-center"><span><?php echo number_format($product['price'] * $product['quantity'], 0, '.', '.'); ?>đ</span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </tfoot>
        </table>
    </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    document.title = "San pham";


    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<?php include './footer.php'; ?>

</html>