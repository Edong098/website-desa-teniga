<?php
$konek = mysqli_connect("localhost", "root", "", "desa_teniga");

if (!$konek) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
