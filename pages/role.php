<?php
// $selectUser = mysqli_query($koneksi, "SELECT users.name, users.email, users.id FROM users ORDER BY id DESC");
$selectUser = mysqli_query($koneksi, "SELECT * FROM roles ORDER BY id DESC"); // DESC: urutan data dari terbesar ke terkecil, contoh : 5,4,3,2,1
// ASC: Kebalikanya lah ya
$rows = mysqli_fetch_all($selectUser, MYSQLI_ASSOC);
// $rows = mysqli_fetch_assoc($selectUser);
// $var_dump ($rows);
// die;

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    print_r($id);
    // die;
    $delete = mysqli_query($koneksi, "DELETE FROM roles WHERE id='$id'");
    header("location:?page=role");
    exit();
}

?>

<div class="card">
    <h5 class="card-header">
        Management Role
    </h5>
    <div class="card-body">
        <div class="mb-2" align="right">
            <a href="?page=create-role" class="btn btn-primary">Create New User</a>
        </div>
        <div class="table-responsive">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                $status = "Role create succesfully!";
                $location = "?page=role";
                echo statusSuccess($status, $location);
            }
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Descriptions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $index => $r) {
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $r['name'] ?></td>
                            <td><?= $r['description'] ?></td>
                            <td><?= getStatus($r['is_active']) ?></td>
                            <td>
                                <a href="?page=create-role&edit=<?= $r['id'] ?>" class="btn btn-success">Edit</a>
                                <form action="?page=role&delete=<?= $r['id'] ?>" method="post" class="d-inline">
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