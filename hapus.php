<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}
require("db.php");
$id = $_GET["id"];


if (hapus($id) > 0) {
    echo '<script>
            alert("berhasil dihapus")
            document.location.href = "index.php"
            </script>';
} else {
    echo '<script>
            alert("gagal dihapus")
            document.location.href = "index.php"
            </script>';
}
