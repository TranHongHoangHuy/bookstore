<?php
include '../conn.php';

$customers = $pdo->query("SELECT * FROM user")->fetchAll(PDO::FETCH_ASSOC);

?>
<?php
require './admin_header.php'
?>

<main style="min-height: 800px;">
    <div class="container mt-5 mb-5">
        <h1 class="text-center"> Thông tin khách hàng</h1>
        <a href="./add_user.php" class="btn btn-primary" style="margin-bottom: 30px;">
            <i class="fa fa-plus"></i> Thêm khách hàng</a>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer) : ?>
                    <tr>
                        <td class="td-center"><?php echo $customer['name']; ?></td>
                        <td class="td-center"><?php echo $customer['address']; ?></td>
                        <td class="td-center"><?php echo $customer['phone']; ?></td>
                        <td class="td-center">
                            <form method="post" action="delete_user.php">
                                <input type="hidden" name="id_user" value="<?php echo $customer['id_user']; ?>">
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
                    <th>Tên</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
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
    document.title = "Khach hang";


    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<?php include './footer.php'; ?>

</html>