<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}
require("db.php");
//mengecek apak tombol sudah di klik

if (isset($_POST["submit"])) {

    // var_dump($_FILES);die;
    //cek keberhasilan data
    if (tambah($_POST) > 0) {
        echo '<script>
            alert("data berhasil ditambahkan")
            document.location.href = "index.php"
            </script>';
    } else {
        echo '<script>
            alert("data gagal ditambahkan")
            document.location.href = "index.php"
            </script>';
    }

    echo mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah</title>
</head>

<body>
    <h1>Tambah Data Anime</h1>
    <ul>
        <form action="" method="post" enctype="multipart/form-data">
            <li>
                <label for="judul">Judul</label>
                <input type="text" name="judul" id="judul" required>
            </li>
            <li>
                <label for="studio">Studio</label>
                <input type="text" name="studio" id="studio">
            </li>
            <li>
                <label for="tahun">Tahun</label>
                <input type="text" name="tahun" id="tahun">
            </li>
            <li>
                <label for="status">Status</label>
                <input type="text" name="status" id="status">
            </li>
            <li>
                <label for="gambar">Gambar</label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <button type="submit" name="submit">Buat</button>
        </form>
    </ul>
</body>

</html>