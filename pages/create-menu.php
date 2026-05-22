<?php
if (isset($_POST['simpan'])) {
    $name = htmlspecialchars($_POST['name']);
    $parent_id = $_POST['parent_id'] ?: 'NULL';
    $url = htmlspecialchars($_POST['url']);
    $icon = htmlspecialchars($_POST['icon']);
    $is_active = htmlspecialchars($_POST['is_active']);
    $sort_order = $_POST['sort_order'];

    mysqli_query($koneksi, "INSERT INTO menus(name, parent_id, url, icon, is_active , sort_order) VALUES ('$name',$parent_id,'$url','$icon','$is_active','$sort_order')");
    header('location:?page=menu&status=success');
}





$id = $_GET['edit'] ?? '';
// $id = isset($_GET['idEdit']) ? $_GET['idEdit'] : '';
$query = mysqli_query($koneksi, "SELECT * FROM menus WHERE id='$id' ");
$rEdit = mysqli_fetch_assoc($query); // mengambil atau membuat data dari table menus



if (isset($_POST['edit'])) {
    $name = htmlspecialchars($_POST['name']);
    $parent_id = $_POST['parent_id'] ?: 'NULL';
    $url = htmlspecialchars($_POST['url']);
    $icon = htmlspecialchars($_POST['icon']);
    $is_active = htmlspecialchars($_POST['is_active']);
    $sort_order = $_POST['sort_order'];



    mysqli_query($koneksi, "UPDATE menus SET name='$name',parent_id=$parent_id,url= '$url',icon= '$icon', is_active='$is_active', sort_order='$sort_order' WHERE id='$id'");
    header('location:?page=menu');
}

// $status = $_GET['status'] ?? '';

// IS : adalah
$queryParent = mysqli_query($koneksi, "SELECT * FROM menus WHERE parent_id IS NULL");
$rowParent = mysqli_fetch_all($queryParent, MYSQLI_ASSOC);

?>

<div class="card">
    <h5 class="card-header">
        <?php echo isset($_GET['edit']) ? "Edit" : "Create New"  ?> Menu
    </h5>
    <div class="card-body">
        <form action="" method="post">
            <div class="row mb-3">
                <div class="col-6">
                    <label for="" class="form-label">Name</label>
                    <input type="text" name="name" value="<?= isset($_GET['edit']) ? $rEdit['name'] : '' ?>"
                        class="form-control" placeholder="Enter your Name" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="" class="form-label">Parent Id</label>
                    <select name="parent_id" id="" class="form-control" placeholer="Select One"><?= $id ? $rEdit['parent_id'] : '' ?>
                        <option value="">Select One</option>
                        <?php foreach ($rowParent as $parent): ?>
                            <option value="<?= $parent['id'] ?>"><?= $parent['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-6 mb-3">
                    <label for="" class="form-label">Icon</label>
                    <input name="icon" type="text" id="" class="form-control" placeholder="Enter Icon"><?= $id ? $rEdit['icon'] : '' ?>
                    </input>
                </div>
                <div class="col-6 mb-3">
                    <label for="" class="form-label">Url</label>
                    <input name="url" type="text" id="" class="form-control" placeholder="Enter URL"><?= $id ? $rEdit['url'] : '' ?>
                    </input>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6 mb-3">
                    <label for="" class="form-label">Sort Order</label>
                    <input name="sort_order" type="number" id="" class="form-control" placeholder="Enter Sort Order"><?= $id ? $rEdit['sort_order'] : '' ?>
                    </input>
                </div>
                <div class="col-6">
                    <label for="" class="form-label d-">Status*</label>
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