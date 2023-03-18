<?php

$koneksi = mysqli_connect("localhost", "root", "", "toko_baju_sjhtera_db");
$id = $_GET['id'];

mysqli_query($koneksi,"DELETE FROM product WHERE id = '$id'" );

header("location: ../index.php");

?>