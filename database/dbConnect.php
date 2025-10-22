<?php
$host = "127.0.0.1";
$user = "webdesa";
$pass = "Desa@2025!"; 
$db   = "desa_teniga";  

$konek = new mysqli($host, $user, $pass, $db);
if ($konek->connect_errno) {
    error_log("DB connect error: " . $konek->connect_error);
    die("Koneksi database gagal.");
}
$konek->set_charset("utf8mb4");
