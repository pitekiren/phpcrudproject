<?php
    $conn = mysqli_connect("localhost","root","","myanimelist");
    function query($query){
        global $conn;
        $result = mysqli_query($conn,$query);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function tambah($data){
        global $conn;
        $judul = $data["judul"];
        $studio = $data["studio"];
        $tahun = $data["tahun"];
        $status = $data["status"];

        //upload gambar
        $gambar = upload();
        if(!$gambar){
            return false;
        }
        $query = "INSERT INTO anime
        VALUES
        ('','$judul','$tahun','$studio','$status','$gambar')
    "; 
        mysqli_query($conn,$query);
        return mysqli_affected_rows($conn);
    }

    function upload(){
        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        //cek apakah gambar di upload
        if($error == 4){
            echo "<script> alert('Gambare upload woy') </script>";
            return false;
        }
        // cek type yang di upload

        $validImageExtension = ['jpg','png','jpeg'];
        $ekstensiGambar = explode('.',$namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if(!in_array($ekstensiGambar,$validImageExtension)){
            echo "<script> alert('Kirmnya gambar bangsat!') </script>";
        }

        //jika ukurannya terlalu besar
        if($ukuranFile > 1000000){
            echo "<script> alert('Ukuran ente bangsat!') </script>";
        }
        //Lolos pengecekan gambar
        
        $namaFileBaru = uniqid();
        $namaFileBaru .= ".".$ekstensiGambar;

        move_uploaded_file($tmpName,'img/'.$namaFileBaru);
        
        return $namaFileBaru;
        }

    function hapus($id){
        global $conn;
        mysqli_query($conn,"DELETE FROM anime WHERE id = $id");
        return mysqli_affected_rows($conn);
    }

    function ubah($data){
        global $conn;
        $id = $data["id"];
        $judul = $data["judul"];
        $studio = $data["studio"];
        $tahun = $data["tahun"];
        $status = $data["status"];

        $gambarLama = $data["gambarLama"];
        //cek apakah gambar diganti
        if($_FILES['gambar']['error'] == 4){
            $gambar = $gambarLama;
        }else{
            $gambar = upload();
        }

        $query = "UPDATE anime SET
                    judul = '$judul',
                    tahun = '$tahun',
                    studio = '$studio',
                    status = '$status',
                    gambar = '$gambar'
                    WHERE id = '$id';
    ";
        mysqli_query($conn,$query);
        return mysqli_affected_rows($conn);
      
    }

    function cari($keyword){
        $query = "SELECT * FROM anime WHERE judul LIKE '%$keyword%' OR studio LIKE '$keyword%'";
        return query($query);
    }

    function registrasi($data){
        global $conn;
        
        $username = strtolower(stripslashes($data["username"]));
        $password = mysqli_real_escape_string($conn,$data["password"]);
        $password2 = mysqli_real_escape_string($conn,$data["password2"]);

        //cek username sudah ada atau belum

        $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
        if(mysqli_fetch_assoc($result)){
            echo "<script>
            alert('username sudah ada')
            </script>
            ";
            return false;
        }
        //cek konfirmasi password
        if($password != $password2){
            echo "
            <script> 
                alert('Konfirmasi password tidak sesuai')
            </script>
            ";
            return false;
        }
        //enkripsi password
        $password = password_hash($password,PASSWORD_DEFAULT);

        //memasukan data ke db
        mysqli_query($conn," INSERT INTO user VALUES(
            '','$username','$password'
        )");

        return mysqli_affected_rows($conn);
    }
?>