<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "itembarang";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak dapat terhubung");
}
$nisn        = "";
$kode       = "";
$nama     = "";
$harga     = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from item where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Terhapus";
    }else{
        $error  = "Gagal Terhapus";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from item where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $kode        = $r1['kode'];
    $nama       = $r1['nama'];
    $harga     = $r1['harga'];

    if ($nisn == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { 
    $kode        = $_POST['kode'];
    $nama       = $_POST['nama'];
    $harga     = $_POST['harga'];

    if ($kode && $nama && $harga) {
        if ($op == 'edit') { 
            $sql1       = "update item set kode = '$kode',nama='$nama',harga = '$harga' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Terupdate";
            } else {
                $error  = "Gagal diupdate";
            }
        } else { 
            $sql1   = "insert into item(kode,nama,harga) values ('$kode','$nama','$harga')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Tersimpan";
            } else {
                $error      = "Gagal Tersimpan";
            }
        }
    } else {
        $error = "Data yang dimasukkan tidak benar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BagKU | Menambahkan Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body style="background-image: linear-gradient(to right, #ed765e, #fea858); padding: 0 10px;">
<div style="border: none ; outline:none; max-width: 800px; border-radius: 10px; 
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.125); height: 100%; padding-bottom:30px; background: #fff; margin: 50px auto;">
    <h5 style="padding-top: 30px; color: #ed765e; text-align: center; font-size: 24px;"
            >MENAMBAHKAN BARANG BARU</h5>
 <div>
    <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:4;url=index.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:4;url=index.php");
                }
    ?>
    <form action="" method="POST">
        <input placeholder="KODE BARANG" style="border: 1px solid #ff8ddb; border-radius: 8px; outline: none; height: 50px;
               text-align: left; padding-left: 20px;  width: 75%; margin: 5px 50px; "
               type="text" id="kode" name="kode" value="<?php echo $kode ?>">
        <input placeholder="NAMA BARANG" style="border: 1px solid #ff8ddb; border-radius: 8px; outline: none; height: 50px;
               text-align: left; padding-left: 20px;  width: 75%; margin: 5px 50px; "
               type="text" id="nama" name="nama" value="<?php echo $nama ?>">
        <input placeholder="HARGA BARANG" style="border: 1px solid #ff8ddb; border-radius: 8px; outline: none; height: 50px;
               text-align: left; padding-left: 20px;  width: 75%; margin: 5px 50px; "
               type="text" id="harga" name="harga" value="<?php echo $harga ?>">

        <br><br><br>
        <div style="margin-left:50px;" class="col-12">
            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
        </div>
    </form>

 </div>
</div>
<div style="border: none ; outline:none; max-width: 800px; border-radius: 10px; 
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.125); height: 100%; padding-bottom:30px; background: #fff; margin: 50px auto;">
    <h5 style="padding-top: 30px; color: #ed765e; text-align: center; font-size: 24px;"
            >DAFTAR BARANG</h5>
            
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Kode Barang</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Harga Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from item order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id          = $r2['id'];
                            $kode        = $r2['kode'];
                            $nama        = $r2['nama'];
                            $harga       = $r2['harga'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $kode ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $harga ?></td>> 
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Hapus Data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
</div>
</body>
</html>