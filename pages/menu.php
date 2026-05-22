<?php
// $selectUser = mysqli_query($koneksi, "SELECT users.name, users.email, users.id FROM users ORDER BY id DESC");
$query = mysqli_query($koneksi, "SELECT parent.name as parent_name, menus.* FROM menus LEFT JOIN menus as parent ON parent.id = menus.parent_id ORDER BY menus.id DESC"); // DESC: urutan data dari terbesar ke terkecil, contoh : 5,4,3,2,1
// ASC: Kebalikanya lah ya
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

// print_r($rows);
// die; -> 
// $var_dump ($rows);
// die;

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    print_r($id);
    // die;
    $delete = mysqli_query($koneksi, "DELETE FROM menus WHERE id='$id'");
    header("location:?page=menu");
    exit();
}

?>

<div class="card">
    <h5 class="card-header">
        Management Menu
    </h5>
    <div class="card-body">
        <div class="mb-2" align="right">
            <a href="?page=create-menu" class="btn btn-primary">Create New Menu</a>
        </div>
        <div class="table-responsive">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                $status = "Menu create succesfully!";
                $location = "?page=menu";
                echo statusSuccess($status, $location);
            }
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Parent Id</th>
                        <th>Name</th>
                        <th>URL</th>
                        <th>Icon</th>
                        <th>Sort</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $index => $r) {
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $r['parent_name'] ?></td>
                            <td><?= $r['name'] ?></td>
                            <td><?= $r['url'] ?></td>
                            <td><?= $r['icon'] ?></td>
                            <td><?= $r['sort_order'] ?></td>
                            <td><?= getStatus($r['is_active']) ?></td>
                            <td><a href="?page=create-menu&edit=<?= $r['id'] ?>" class="btn btn-success fw-bold">Edit</a>
                                <form action="?page=menu&delete=<?= $r['id'] ?>" method="post" class="d-inline">
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