<?php
    require("db.php");
    if(isset($_POST["register"])){
        if(registrasi($_POST) > 0){
            echo "
            <script>
            alert('Sukses Membuat akun')
            </script>
            ";
        }else{
            echo "
            <script>
            alert('Gagal Membuat akun')
            </script>
            ";
            echo mysqli_error($conn);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>
    <h1>Halaman Registrasi</h1>
    <ul>
    <form action="" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username"><br>

        <label for="password">Password</label>
        <input type="password" name="password" id="password"><br>

        <label for="password2">Konfirmasi password</label>
        <input type="password" name="password2" id="password2"><br>

        <button type="submit" name ="register"> Daftar </button>


    </form>
    
    </ul>

</body>
</html>