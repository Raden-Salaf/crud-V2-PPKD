<?php
if (isset($_POST['simpan'])) {
    $name = htmlspecialchars($_POST['name']);
    $is_active = htmlspecialchars($_POST['is_active']);
    $description = $_POST['description'];
    // $confirm_password = $_POST['password_confirm'];
    // $passHas = sha1($password);

    // pw tak sama

    mysqli_query($koneksi, "INSERT INTO roles (name, is_active ,description) VALUES ('$name','$is_active','$description')");
    header('location:?page=role&status=success');
}





$id = $_GET['edit'] ?? '';
// $id = isset($_GET['idEdit']) ? $_GET['idEdit'] : '';
$query = mysqli_query($koneksi, "SELECT * FROM roles WHERE id='$id' ");
$rEdit = mysqli_fetch_assoc($query); // mengambil atau membuat data dari table roles



if (isset($_POST['edit'])) {
    $name = htmlspecialchars($_POST['name']);
    $is_active = htmlspecialchars($_POST['is_active']);
    $description = $_POST['description'];



    mysqli_query($koneksi, "UPDATE roles SET name='$name', is_active='$is_active', description='$description' WHERE id='$id'");
    header('location:?page=role');
}

$status = $_GET['status'] ?? '';

?>

<div class="card">
    <h5 class="card-header">
        <?php echo isset($_GET['edit']) ? "Edit" : "Create New"  ?> Role
    </h5>
    <div class="card-body">
        <form action="" method="post">
            <div class="row mb-3">
                <div class="col-6">
                    <label for="" class="form-label">Name</label>
                    <input type="text" name="name" value="<?= isset($_GET['edit']) ? $rEdit['name'] : '' ?>"
                        class="form-control" placeholder="Enter your Name" required>
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Description </label>
                    <textarea name="description" id="" class="form-control"><?= $id ? $rEdit['description'] : '' ?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="" class="form-label">Status*</label>
                    <input type="radio" name="is_active" value="1"
                        <?= $id ? ($rEdit['is_active'] == 1) ? 'checked' : '' : 'checked' ?>> Active
                    <input type="radio" name="is_active" value="0"
                        <?= $id ? ($rEdit['is_active'] == 0) ? 'checked' : '' : '' ?>> Inactive
                </div>
            </div>
            <div class="text-end mt-2 ">
                <button type="submit" class="btn btn-primary"
                    name="<?= isset($_GET['edit']) ? 'edit' : 'simpan' ?>"><?= isset($_GET['edit']) ? 'Save Change' : 'Save' ?></button>
                <a href="?page=user" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

    </div>
</div>
<!-- </h5> -->