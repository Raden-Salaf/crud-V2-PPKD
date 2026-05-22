<?php
$selectUser = mysqli_query($koneksi, "SELECT users.name, users.email, users.id FROM users ORDER BY id DESC");
// $selectUser = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC"); // DESC: urutan data dari terbesar ke terkecil, contoh : 5,4,3,2,1
// ASC: Kebalikanya lah ya
$rows = mysqli_fetch_all($selectUser, MYSQLI_ASSOC);
// $rows = mysqli_fetch_assoc($selectUser);
// $var_dump ($rows);
// die;

if (isset($_GET['idDelete'])) {
    $id = $_GET['idDelete'];
    print_r($id);
    // die;
    $delete = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");
    header("location:?page=user");
    exit();
}

?>

<div class="card">
    <h5 class="card-header">
        User Data
    </h5>
    <div class="card-body">
        <div class="mb-2" align="right">
            <a href="?page=user-create-edit" class="btn btn-primary">Create New User</a>
        </div>
        <div class="table-responsive">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                $status = "Data Berhasil ditambah!";
                $location = "?page=user";
                echo statusSuccess($status, $location);
            }
            ?>
            <table class="table table-bordered">
                <thead>


                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
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
                            <td><?= $r['email'] ?></td>
                            <td>
                                <a href="?page=user-create-edit&idEdit=<?= $r['id'] ?>" class="btn btn-success">Edit</a>
                                <form action="?page=user&idDelete=<?= $r['id'] ?> ?>" method="post" class="d-inline">
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