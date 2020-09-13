<?php
    session_start();
    if(!isset($_SESSION["login"])){
        header("location: login.php");
        exit;
    }
    require("db.php");
    //mengecek apak tombol sudah di klik
    $id = $_GET["id"];

    $anime = query("SELECT * FROM anime WHERE id = $id")[0];

    
    if(isset($_POST["submit"])){
        //cek keberhasilan data
        if(ubah($_POST) > 0){
            echo '<script>
            alert("berhasil diubah")
            document.location.href = "index.php"
            </script>';
        }
        else{
            echo '<script>
            alert("Gagal diubah")
            </script>';
            echo mysqli_error($conn);
        }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ubah</title>
</head>
<body>
    <h1>ubah Data Anime</h1>
    <ul>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $anime["id"] ?>> 

            <li>
                <label for="judul">Judul</label>
                <input type="text" name="judul" id="judul" required value="<?= $anime["judul"]?>">
            </li>
            <li>
                <label for="studio">Studio</label>
                <input type="text" name="studio" id="studio" required value="<?= $anime["studio"]?>">
            </li>
            <li>
                <label for="tahun">Tahun</label>
                <input type="text" name="tahun" id="tahun" required value="<?= $anime["tahun"]?>">
            </li>
            <li>
                <label for="status">Status</label>
                <input type="text" name="status" id="status" required value="<?= $anime["status"]?>">
            </li>
            <li>
                <label for="gambar">Gambar</label>
                <img src="img/<?= $anime["gambar"]?>" alt="">
                <input type="file" name="gambar" id="gambar">
            </li>
            <input type="hidden" name="gambarLama" value="<?= $anime["gambar"]?>">
            <button type="submit" name="submit">ubah</button>
        </form>
    </ul>
</body>
</html>