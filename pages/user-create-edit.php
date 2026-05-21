<?php
if (isset($_POST['simpan'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['password_confirm'];
    $passHas = sha1($password);

    // pw tak sama
    if ($password !== $confirm_password) {
        header('location:?user-create-edit&status=password_not_match');
        exit();
    }
    $cekEmail = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($cekEmail) > 0) {
        header('location:?page=user-create-edit&status=email_exists');
        exit();
        // if ($password == $confirm_password) {}

    }
    mysqli_query($koneksi, "INSERT INTO users (name,email,password) VALUES ('$name','$email','$passHas')");
    header('location:?page=user&status=success');
}




$id = $_GET['idEdit'] ?? '';
// $id = isset($_GET['idEdit']) ? $_GET['idEdit'] : '';
$selectUser = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id' ");
$rEdit = mysqli_fetch_assoc($selectUser);



if (isset($_POST['edit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['password_confirm'];
    $passHas = sha1($password);

    if (empty($password)) {
        mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email' WHERE id='$id'");
        header('location:?page=user');
        exit();

        // $updateUser = mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email' WHERE id='$id'");
    } else {
    }

    if ($password !== $confirm_password) {
        header('location:?page=user-create-edit&idEdit=' . $id . '$status=password_not_match');
        exit();
    }
    mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id'");
    header('location:?page=user');
}

$status = $_GET['status'] ?? '';

?>

<div class="card">
    <!-- <h5 class="card-header "> -->
    <h5 class="card-header">
        <?php echo isset($_GET['idEdit']) ? "Edit" : "Create New"  ?> User
    </h5>
    <div class="card-body">
        <?php if ($status == "password_not_match"): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!!!</strong> Password do not match
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif ?>
        <?php
        if ($status == 'email_exists') {
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'> <strong>Error!!</strong> This email already registerred. <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button> <?div>";
        }
        ?>
        <form action="" method="post">
            <div class="row mb-3">
                <div class=" col-6">
                    <label for="" class="form-label">Name</label>
                    <input type="text" name="name" value="<?= isset($_GET['idEdit']) ? $rEdit['name'] : '' ?>"
                        class="form-control" placeholder="Enter your Name" required>
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Email *</label>
                    <input type="email" name="email" value="<?= isset($_GET['idEdit']) ? $rEdit['email'] : '' ?>"
                        class="form-control" placeholder="Ex : bejo@gmail.com" required>
                </div>
            </div>
            <div class="row mb-4 justify-content-end">
                <div class="col-6">
                    <label for="" class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control" placeholder="Input yours Password" <?= !$id ? 'required' : '' ?>>
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Password Confirm *</label>
                    <input type="password" name="password_confirm" class="form-control" placeholder="Password Confirm" <?= !$id ? 'required' : ''  ?>>
                </div>
                <?php if ($id): ?>
                    <div class="mt-2 text-secondary">
                        <p class="px-1 py-2">Leave blank if you dont want to change the password</p>
                    </div>
                <?php endif ?>
            </div>
            <div class="text-end mt-2 ">
                <button type="submit" class="btn btn-primary"
                    name="<?= isset($_GET['idEdit']) ? 'edit' : 'simpan' ?>"><?= isset($_GET['idEdit']) ? 'Save Change' : 'Save' ?></button>
                <a href="?page=user" class="btn btn-secondary">Cancel</a>
            </div>

        </form>
    </div>
    <!-- </h5> -->
</div>
</div>