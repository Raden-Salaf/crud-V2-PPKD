<?php
if (isset($_POST['simpan'])) {
    $category_name = htmlspecialchars($_POST['category_name']);
    // CEK CATEGORIES
    $cek = mysqli_query($koneksi, "SELECT category_name FROM categories WHERE category_name = '$category_name'");

    if (mysqli_num_rows($cek) > 0) {
        header("location:?page=create-category&status=category-exist");
        exit();
    }

    // END CATEGORIE
    $query = mysqli_query($koneksi, "INSERT INTO categories (category_name) VALUES ('$category_name')");
    if ($query) {
        header("location:?page=category&status=success");
        exit();
    }
}
if (isset($_GET["edit"])) {
    $id = $_GET["edit"] ? base64_decode($_GET["edit"]) : "";
    $select = mysqli_query($koneksi, "SELECT * FROM categories WHERE id='$id'");
    $row_edit = mysqli_fetch_assoc($select);
    if (isset($_POST["edit"])) {
        $category_name = htmlspecialchars($_POST["category_name"]);
        $cek = mysqli_query($koneksi, "SELECT category_name FROM categories WHERE category_name = 'category_name'");
        if (mysqli_num_rows($cek) > 0) {
            header("location:?page=create-category&edit=" . $_GET["edit"] . "&status=category-exist");
            exit();
        }
        // END CEK CATEGORIES
        $update = mysqli_query($koneksi, "UPDATE categories SET category_name='$category_name' WHERE id='$id'");
        if ($update) {
            header("location:?page=category&status=success");
            exit();
        }
    }
}
?>

<div class="card">
    <h5 class="card-header">
        Create Category
    </h5>
    <div class="card-body">
        <form action="" method="post">
            <label for="" class="from-label">Category Name</label>
            <input type="text" class="form-control" name="category_name" value="<?= isset($id) ? $row_edit['category_name'] : '' ?>" required>
            <?php
            $status = '';
            if (isset($_GET["status"]) && $_GET("status") == "category-exist") {
                $status = "Category Name already exist!!";
                echo inputFailed($status);
            }
            ?>
            <br>

            <button type="submit" name="<?= isset($id) ? 'edit' : 'simpan'  ?>" class="btn btn-primary mt-2"><?= isset($id) ? 'update' : 'create'  ?></button>
            <a href="?page=category" class="btn btn-secondary mt-2">Cancel</a>
        </form>
    </div>
</div>