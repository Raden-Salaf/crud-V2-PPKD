<?php
$cat = mysqli_query($koneksi, "SELECT * FROM categories");
$rowCategories = mysqli_fetch_all($cat, MYSQLI_ASSOC);
if (isset($_POST['simpan'])) {
    $category_id = htmlspecialchars($_POST['category_id']);
    $product_name = htmlspecialchars($_POST['product_name']);
    $qty = htmlspecialchars($_POST['qty']);
    $price = htmlspecialchars($_POST['price']);
    $unit = htmlspecialchars($_POST['unit']);
    $description = $_POST['description'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    //CEK PRODUCTS :
    $cek = mysqli_query($koneksi, "SELECT product_name FROM products WHERE product_name='$product_name'");
    if (mysqli_num_rows($cek) > 0) {
        header("location:?page=create-product&status=product-exist");
        exit();
    }
    // END CEK PRODUCTS

    $product_image = time() . '_' . $_FILES['product_image']['name'];
    $tmp_name = $_FILES['product_image']['tmp_name'];
    move_uploaded_file($tmp_name, "assets/uploads/" . $product_image);
    // var_dump($product_image);

    $insert = mysqli_query($koneksi, "INSERT INTO products (category_id, product_image, product_name, qty, price, unit, description, is_active) VALUES ('$category_id', '$product_image', '$product_name', '$qty', '$price', '$unit', '$description', '$is_active')");

    if ($insert) {
        header("location:?page=product&status=success");
        exit();
    }
}
if (isset($_GET['edit'])) {
    $id = $_GET['edit'] ?? 0;
    $selectProduct = mysqli_query($koneksi, "SELECT * FROM products WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($selectProduct);
    if (isset($_POST['edit'])) {
        $category_id = htmlspecialchars($_POST['category_id']);
        $product_name = htmlspecialchars($_POST['product_name']);
        $qty = htmlspecialchars($_POST['qty']);
        $price = htmlspecialchars($_POST['price']);
        $unit = htmlspecialchars($_POST['unit']);
        $description = $_POST['description'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if ($_FILES['product_image']['name'] != '') {
            $product_image = time() . '_' . $_FILES['product_image']['name'];
            $tmp_name = $_FILES['product_image']['tmp_name'];
            if (file_exists("assets/uploads/" . $rowEdit['product_image']) && !empty($rowEdit['product_image'])) {
                unlink("assets/uploads/" . $rowEdit['product_image']);
            }
            move_uploaded_file($tmp_name, "assets/uploads/" . $product_image);
        } else {
            $product_image = $rowEdit['product_image'];
        }

        //CEK PRODUCTS :
        $cek = mysqli_query($koneksi, "SELECT product_name FROM products WHERE product_name='$product_name'");
        if (mysqli_num_rows($cek) > 0) {
            $update = mysqli_query($koneksi, "UPDATE products SET category_id='$category_id', product_image='$product_image', qty='$qty', price='$price', unit='$unit', description='$description', is_active='$is_active' WHERE id='$id'");
            header("location:?page=product");
            exit();
        }
        // END CEK PRODUCTS
        $update = mysqli_query($koneksi, "UPDATE products SET category_id='$category_id', product_image='$product_image', product_name='$product_name', qty='$qty', price='$price', unit='$unit', description='$description', is_active='$is_active' WHERE id='$id'");
        if ($update) {
            header("location:?page=product");
            exit();
        }
    }
}
?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Create Category</h5>
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="" class="form-label">Category Name</label>
                <select name="category_id" class="form-select" required>
                    <option value="">--Choose Category--</option>
                    <?php
                    foreach ($rowCategories as $key => $v) {
                    ?>
                        <option value="<?= $v['id'] ?>" <?= isset($_GET['edit']) && $v['id'] == $rowEdit['category_id'] ? 'selected' : '' ?>><?= $v['category_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="product_name" value="<?= isset($_GET['edit']) ? $rowEdit['product_name'] : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Product Image</label>
                <div class="mb-2">
                    <img src="assets/uploads/<?php echo isset($_GET['edit']) ? $rowEdit['product_image'] : '' ?>" alt="" width="150">
                </div>
                <input type="file" name="product_image" class="form-control">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Quantity</label>
                <input type="number" class="form-control" value="<?= isset($_GET['edit']) ? $rowEdit['qty'] : '' ?>" name="qty">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Price</label>
                <input type="number" step="0.01" name="price" value="<?= isset($_GET['edit']) ? $rowEdit['price'] : '' ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Unit</label>
                <input type="text" name="unit" value="<?= isset($_GET['edit']) ? $rowEdit['unit'] : '' ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Description</label>
                <textarea name="description" id="default-editor" class="form-control" cols="30" rows="5"><?= isset($_GET['edit']) ? $rowEdit['description'] : '' ?></textarea>
            </div>
            <div class="mb-3">
                <div class="form-check form-switch">
                    <?php
                    $isActive = true;
                    if (isset($_GET['edit']) && $rowEdit['is_active'] == 0) {
                        $isActive = false;
                    }
                    ?>
                    <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="flexSwitchCheckChecked" <?= $isActive ? 'checked' : '' ?>>
                    <label class="form-check-label" for="flexSwitchCheckChecked">Status (Active/Inactive)</label>
                </div>
            </div>

            <button type="submit" name="<?php echo isset($id) ? 'edit' : 'simpan' ?>"
                class="btn btn-primary mt-2">
                <?php echo isset($id) ? 'Update' : 'Create' ?>
            </button>


            <a href="?page=product" class="btn btn-secondary mt-2">Cancel</a>
        </form>
    </div>
</div>