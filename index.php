<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}
require("db.php");
//konfigurasi pagination
$jmlDataPerHalaman = 2;
$jmlData = count(query("SELECT * FROM anime"));

$jmlHalaman = ceil($jmlData / $jmlDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jmlDataPerHalaman * $halamanAktif)- $jmlDataPerHalaman;

$animes = query("SELECT * FROM anime ORDER BY id DESC LIMIT $awalData,$jmlDataPerHalaman");

//Jika tombol cari di klik
if (isset($_POST["submit"])) {
    $animes = cari($_POST["keyword"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <style>
    @media print{
        
    }
    </style>
</head>

<body>
    <a href="logout.php">logout</a>
    <h1>Anime List</h1>
    <a href="tambah.php">Tambah Data Anime</a>
    <form action="" method="post">
        <label for="keyword">Cari Anime</label><br>
        <input type="text" name="keyword" id="keyword" size="50" autofocus placeholder="masukan keyword pencarian..." autocomplete="off">
        <button type="submit" name="submit">search</button>
    </form>
    <br>
    <!-- navigasi -->
    <?php if($halamanAktif != 1) :?>
    <a href="?halaman=<?= $halamanAktif - 1 ?>" style="font-weight: bold;">&laquo</a>
    <?php endif ?>

    <?php for($i = 1; $i <= $jmlHalaman; $i++):?>
    <?php if($i == $halamanAktif): ?>
    <a href="?halaman=<?= $i?>" style="font-weight: bold;color: red;"><?= $i ?></a>
    <?php else: ?>
    <a href="?halaman=<?= $i?>"><?= $i ?></a>
    <?php endif; ?>
    <?php endfor; ?>
    <?php if($halamanAktif !=  $jmlHalaman) :?>
    <a href="?halaman=<?php echo $halamanAktif + 1 ?>" style="font-weight: bold;">&raquo;</a>
    <?php endif ?>
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>No.</th>
            <th>Gambar</th>
            <th>Aksi</th>
            <th>Judul</th>
            <th>Studio</th>
            <th>Tahun</th>
            <th>Status</th>
        </tr>
        <?php $i = 1 ?>
        <?php foreach ($animes as $anime) : ?>
            <tr>
                <td><?= $i ?></td>
                <td><img style="height: 25%;" src="img/<?= $anime["gambar"]; ?>" alt=""></td>
                <td><a href="ubah.php?id=<?= $anime["id"]; ?>">Ubah</a>|<a href="hapus.php?id=<?= $anime["id"]; ?>" onclick="return confirm('yakin?')">Hapus</a></td>
                <td><?= $anime["judul"] ?></td>
                <td><?= $anime["studio"] ?></td>
                <td><?= $anime["tahun"] ?></td>
                <td><?= $anime["status"] ?></td>
            </tr>
            <?php $i++ ?>
        <?php endforeach ?>
    </table>
</body>

</html>