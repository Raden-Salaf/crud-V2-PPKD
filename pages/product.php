<?php
$select = mysqli_query($koneksi, "SELECT products.*, categories.category_name FROM products LEFT JOIN categories ON products.category_id = categories.id ORDER BY id DESC");
$row_products = mysqli_fetch_all($select, MYSQLI_ASSOC);
// var_dump($row_product); -> untuk mengecek apakah query yg di input benar?

if(isset($_GET['delete'])){
    $id = $_GET['delete'] ?? 0 ;
    $cek_foto = mysqli_query($koneksi,"SELECT product_image FROM products WHERE id='$id'");
    $row_foto = mysqli_fetch_all($cek_foto, MYSQLI_ASSOC);

    if($row_foto){
        $foto = $row_foto["product_image"];
        if (file_exists("assets/uploads".$foto) && !empty($foto)) {
            unlink("assets/uploads".$foto);
        }
    }

    $delete = mysqli_query($koneksi,"DELETE FROM products WHERE id='$id'");
    if ($delete){
        header("location:?page=product");
        exit();
    } 
}

?>


<div class="card">
    <h5 class="card-header">
        Manage Product
    </h5>
    <div class="card-body">
        <div class="mb-2 d-flex justify-content-end">
            <a href="?page=create-product" class="btn btn-primary border-2">Create Product</a>
        </div>
        <div class="table-responsive">
            <?php
            // if (isset($_GET['status']) && $_GET['status'] == 'success') {
            //     $status = "Data Berhasil ditambah!";
            //     $location = "?page=category";
            //     echo statusSuccess($status, $location);
            // }
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($row_products as $index => $r) {
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><img src="assets/uploads/<?= $r['product_image'] ?>" alt="" width="50%"></td>
                            <td><?= $r['product_name'] ?></td>
                            <td><?= $r['category_name'] ?></td>
                            <td><?= $r['qty'] ?></td>
                            <td>Rp.<?= number_format($r['price'], 2, ',', '.') ?></td>
                            <td><?= $r['unit'] ?></td>
                            <td><?= getStatus($r['is_active']) ?></td>
                            <td>
                                <a href="?page=create-product&edit=<?= $r['id'] ?>" class="btn btn-success fw-bold">Edit</a>
                                <form action="?page=product&delete=<?= $r['id'] ?>" method="post" class="d-inline">
                                    <button class="btn btn-danger" onclick="return confirm('Kowe Yakin Pora!?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>