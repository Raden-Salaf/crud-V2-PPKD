<?php
$select_categories = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY id DESC");
$row_catergories = mysqli_fetch_all($select_categories, MYSQLI_ASSOC);

if (isset($_GET["delete"])) {
    $id = $_GET["delete"] ?? 0;
    $delete = mysqli_query($koneksi, "DELETE FROM categories WHERE id='$id'");
    header("location:?page=category");
    exit();
}

?>


<div class="card">
    <h5 class="card-header">
        Manage Category
    </h5>
    <div class="card-body">
        <div class="mb-2 d-flex justify-content-end">
            <a href="?page=create-category" class="btn btn-primary">Create Category</a>
        </div>
        <div class="table-responsive">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                $status = "Data Berhasil ditambah!";
                $location = "?page=category";
                echo statusSuccess($status, $location);
            }
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($row_catergories as $index => $r) {
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $r['category_name'] ?></td>
                            <td>
                                <a href="?page=create-category&edit=<?= base64_encode($r['id']) ?>" class="btn btn-success fw-bold">Edit</a>
                                <form action="?page=category&delete=<?= $r['id'] ?>" method="post" class="d-inline">
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