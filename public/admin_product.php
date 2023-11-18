<?php
include '../conn.php';

$products = $pdo->query("SELECT * FROM product")->fetchAll(PDO::FETCH_ASSOC);

?>
<?php
require './admin_header.php'
?>

<main style="min-height: 500px;">
    <div class="container mt-5 mb-5">
        <h1 class="text-center"> Thông tin sản phẩm</h1>
        <a href="./add_product.php" class="btn btn-primary" style="margin-bottom: 30px;">
            <i class="fa fa-plus"></i> Thêm sản phẩm</a>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Tác giả</th>
                    <th>Giá</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><img src="<?php echo $product['image_link']; ?>" style="height: 100px;"></td>
                        <td class="td-center"><?php echo $product['productName']; ?></td>
                        <td class="td-center"><?php echo $product['author']; ?></td>
                        <td class="td-center"><span><?php echo number_format($product['price'], 0, '.', '.'); ?>đ</span></td>
                        <td class="td-center" style="height: auto; text-align: center; line-height: auto;">
                            <form method="post" action="edit_product.php" style="margin-bottom: 5px;">
                                <input type="hidden" name="id_product" value="<?php echo $product['id_product']; ?>">
                                <button type="submit" class="btn btn-xs btn-primary" name="detail">
                                    <i alt="Edit" class="fa fa-pencil"></i>
                                </button>
                            </form>
                            <form method="post" action="delete_product.php">
                                <input type="hidden" name="id_product" value="<?php echo $product['id_product']; ?>">
                                <button type="submit" class="btn btn-xs btn-danger" name="delete">
                                    <i alt="Delete" class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Tác giả</th>
                    <th>Giá</th>
                    <th>Action</th>
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