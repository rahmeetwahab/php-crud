<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "toko";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}

$id = "";
$nama = "";
$harga = "";
$stok = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id_barang'];
    $sql1 = "delete from barang where id_barang = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal melakukan hapus data";
    }
}

if ($op == "edit") {
    $id = $_GET['id_barang'];
    $sql1 = "select *from barang where id_barang = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nama = $r1['nama_barang'];
    $harga = $r1['harga_barang'];
    $stok = $r1['jumlah_barang'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { //untuk create
    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga_barang'];
    $stok = $_POST['jumlah_barang'];

    if ($nama && $harga && $stok) {
        if ($op == 'edit') {
            $sql1 = "update barang set nama_barang = '$nama', harga_barang = '$harga', jumlah_barang = '$stok' where id_barang = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil di update";
            } else {
                $error = "Data gagal diupdate";
            }
        } else {
            $sql1 = "insert into barang (nama_barang, harga_barang, jumlah_barang) values ('$nama', '$harga', '$stok')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data baru";
            } else {
                $error = "Gagal memasukkan data baru";
            }
        }
    } else {
        $error = "Silahkan masukkan semua data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOKO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }

        .logo{
            font-weight: bolder;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }

        .radius{
            border-radius: 20px;
        }

        ul{
            list-style: none;
        }

        ul li{
            margin-top: 40px;
            margin-bottom: 30px;
            font-size: large;
            font-weight: bold;
        }

        ul li a{
            text-decoration: none;
        }

        footer{
            text-align: center;
            height: 75px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-light ms-4 logo">LIWA</a>
            <form class="d-flex">
                <button class="btn btn-outline-light bg-success logo" type="submit">Login</button>
            </form>
        </div>
    </nav>
    <div class="mx-5">
        <div class="row">
            <div class="col-2 mt-5 bg-primary radius">
                <ul class="mt-5 pt-5 ms-3">
                    <li><a href="index.html" class="text-light">Barang</a></li>
                    <li><a href="#" class="text-light">Detail Jual</a></li>
                    <li><a href="#" class="text-light">Konsumen</a></li>
                    <li><a href="#" class="text-light">Cetak Nota</a></li>
                </ul>
            </div>
            <div class="col-10">
                <!-- untuk memasukkan data  -->
                <div class="card">
                    <div class="card-header">
                        Create / Edit
                    </div>
                    <div class="card-body">
                        <?php
                        if ($error) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error ?>
                            </div>
                        <?php
                            header("refresh:5;url=index.php");
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
                        <form action="" method="post">
                            <div class="mb-3 row">
                                <label for="nama_barang" class="col-sm-2 col-form-label">Nama Barang</label>
                                <div class="col-sm-10">
                                    <input type="text" name="nama_barang" class="form-control" id="nama_barang" value="<?php echo $nama ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="harga_barang" class="col-sm-2 col-form-label">Harga Barang</label>
                                <div class="col-sm-10">
                                    <input type="text" name="harga_barang" class="form-control" id="harga_barang" value="<?php echo $harga ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="jumlah_barang" class="col-sm-2 col-form-label">Stok Barang</label>
                                <div class="col-sm-10">
                                    <input type="text" name="jumlah_barang" class="form-control" id="jumlah_barang" value="<?php echo $stok ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- untuk mengeluarkan data  -->
                <div class="card">
                    <div class="card-header text-white bg-secondary">
                        Data Barang
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Harga Barang</th>
                                    <th scope="col">Stok Barang</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            <tbody>
                                <?php
                                $sql2 = "select * from barang";
                                $q2 = mysqli_query($koneksi, $sql2);
                                $urut = 1;
                                while ($r2 = mysqli_fetch_array($q2)) {
                                    $id = $r2['id_barang'];
                                    $nama = $r2['nama_barang'];
                                    $harga = $r2['harga_barang'];
                                    $stok = $r2['jumlah_barang'];
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $urut++ ?></th>
                                        <td scope="row"><?php echo $nama ?></td>
                                        <td scope="row"><?php echo $harga ?></td>
                                        <td scope="row"><?php echo $stok ?></td>
                                        <td scope="row">
                                            <a href="index.php?op=edit&id_barang=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                            <a href="index.php?op=delete&id_barang=<?php echo $id ?>" onclick="return confirm('Yakin ingin menghapus data?')"><button type="button" class="btn btn-danger">Delete</button>
                                            </a>

                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="mt-5 bg-secondary">
        <h6 class="pt-4 text-light">&copy;Kelompok 5</h6>
    </footer>
</body>

</html>