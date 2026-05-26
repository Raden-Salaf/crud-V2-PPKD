<?php
$cat = mysqli_query($koneksi, "SELECT * FROM categories");
$row_categories = mysqli_fetch_all($cat, MYSQLI_ASSOC);

if (isset($_POST["simpan"])) {
    $category_id = htmlspecialchars($_POST['category_id']);
    $product_name = htmlspecialchars($_POST['product_name']);
    $qty = htmlspecialchars($_POST['qty']);
    $price = htmlspecialchars($_POST['price']);
    $unit = htmlspecialchars($_POST['unit']);
    $description = htmlspecialchars($_POST['description']);
    $is_active = htmlspecialchars($_POST['is_active']) ? 1 : 0;

    $product_image = time() . '_' . $_FILES['product_image']['name'];
    $tmp_name = $_FILES['product_image']['tmp_name'];
    move_uploaded_file($tmp_name, "assets/uploads/" . $product_image);

    $insert = mysqli_query($koneksi, "INSERT INTO products (category_id, product_image, product_name, qty, price, unit, description, is_active) VALUES ('$category_id','$product_image','$product_name','$qty', '$price', '$unit','$description','$is_active' )");

    if ($insert) {
        header("location:?page=product&status=success");
        exit();
    }
}

if (isset($_GET["edit"])) {
    $id = $_GET['edit'] ?? 0;
    $select_product = mysqli_query($koneksi, "SELECT * FROM products WHERE id='$id'");
    $row_edit = mysqli_fetch_assoc($select_product);
    if (isset($_POST["edit"])) {
        $category_id = htmlspecialchars($_POST["category_id"]);
        $product_name = htmlspecialchars($_POST["product_name"]);
        $qty = htmlspecialchars($_POST["qty"]);
        $price = htmlspecialchars($_POST["price"]);
        $unit = htmlspecialchars($_POST["unit"]);
        $description = htmlspecialchars($_POST['description']);
        $is_active = htmlspecialchars($_POST['is_active']) ? 1 : 0;

        if ($_FILES['product_image']['name'] != '') {
            $product_image = time() . '_' . $_FILES['product_image']['name'];
            $tmp_name = $_FILES['product_image']['tmp_name'];
            if (file_exists('assets/uploads' . $product_image) && !empty($row_edit['product_image'])) {
                unlink($product_image, "assets/uploads/" . $row_edit["product_image"]);
            }
            move_uploaded_file($tmp_name, "assets/uploads/" . $product_image);
        } else {
            $product_image = $row_edit["product_image"];
        }

        // CEK PRODUCTS
        $cek = mysqli_query($koneksi, "SELECT product_name FROM products WHERE product_name='$product_name'");
        if (mysqli_num_rows($cek) > 0) {
            $update = mysqli_query($koneksi, "UPDATE products SET category_id='$category_id', product_image='$product_image', product_name='$product_name', qty='$qty', price='$price', unit='$unit', description='$description', is_active='$is_active' WHERE id='$id'");
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
    <h5 class="card-header">
        Create Product
    </h5>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="" class="from-label">Product Name</label>
                <select name="category_id" id="" class="form-select">
                    <option value="">--Choose Category--</option>
                    <?php
                    foreach ($row_categories as $key => $v) {
                    ?>
                        <option value="<?= $v['id'] ?>"><?= $v['category_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="product_name" value="<?= isset($_GET['edit']) ? $row_edit['product_name'] : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Product Image</label>
                <input type="file" class="form-control" name="product_image" value="<?= isset($_GET['edit']) ? $row_edit['product_image'] : '' ?>">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Quantity</label>
                <input type="number" class="form-control" name="qty" value="<?= isset($_GET['edit']) ? $row_edit['qty'] : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Price</label>
                <input type="number" class="form-control" name="price" value="<?= isset($_GET['edit']) ? $row_edit['price'] : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Unit</label>
                <input type="text" class="form-control" name="unit" value="<?= isset($_GET['edit']) ? $row_edit['unit'] : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="default-editor" cols="30" rows="5"><?= isset($_GET['edit']) ? $row_edit['description'] : '' ?>"</textarea>
            </div>
            <div class="form-check form-switch text-danger">
                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="switchCheckChecked" checked>
                <label class="form-check-label" for="switchCheckChecked">Status (Active/Inactive)</label>
            </div>
            <br>

            <button type="submit" name="<?= isset($id) ? 'edit' : 'simpan'  ?>" class="btn btn-primary mt-2"><?= isset($id) ? 'update' : 'create'  ?></button>
            <a href="?page=product" class="btn btn-secondary mt-2">Cancel</a>
        </form>
    </div>
</div>