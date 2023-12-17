<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "eventiumcrud";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nama      = "";
$email          = "";
$password       = "";
$telepon        = "";
$sukses         = "";
$error          = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id         = $_GET['id'];
    $sql1       = "delete from data where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from data where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nama       = $r1['nama'];
    $email      = $r1['email'];
    $password   = $r1['password'];
    $pass       = md5($password);
    $telepon    = $r1['telepon'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nama        = $_POST['nama'];
    $email       = $_POST['email'];
    $pass        = md5($password);
    $telepon     = $_POST['telepon'];

    if ($nama && $email && $telepon) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update data set nama = '$nama', email = '$email', telepon = '$telepon' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into data(nama,email,password,telepon) values ('$nama','$email','$pass','$telepon')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Akun</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1A1716;
            scroll-behavior: smooth
        }

        .mx-auto {
            width: 1000px
        }

        .card {
            margin-top: 10px;
        }

        .card-header {
            background-color: #fdf2bf;
        }

        .card-body {
            background-color: #50473b;
            color: #F7F7E9;
        }

        .table {
            color: #F7F7E9;
        }

        .form-control-plaintext {
            color: #F7F7E9;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card text-center bg-light">
            <div class="card-header text-black">
                Tambahkan / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php"); //5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="email" name="email" value="<?php echo $email ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="telepon" class="col-sm-2 col-form-label">No telp</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="telepon" name="telepon" value="<?php echo $telepon ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="simpan data" class="btn btn-success" />
                    </div>
                </form>
            </div>
        </div>

        <div class="card text-center bg-light">
            <div class="card-header text-black">
                Data Akun
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Password</th>
                            <th scope="col">Telepon</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2   = "select * from data order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2   = mysqli_fetch_array($q2)) {
                            $id         = $r2['id'];
                            $nama   = $r2['nama'];
                            $email      = $r2['email'];
                            $password   = $r2['password'];
                            $telepon    = $r2['telepon'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $email ?></td>
                                <td scope="row"><?php echo $password ?></td>
                                <td scope="row"><?php echo $telepon ?></td>
                                <td scope="row">
                                    <a href="edit.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                    <form action="" method="POST">

                    </form>
            </div>
        </div>
    </div>
</body>

</html>