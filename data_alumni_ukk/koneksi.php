<?php

$koneksi = mysqli_connect('localhost','root','','db_alumni_stella1');
if (!$koneksi) {
    // menutup dan menampilkan erorr
    die("koneksi gagal: ") . mysqli_connect_errno();
}
?>