<?php
session_start();
session_unset(); // Hapus semua variabel sesi
session_destroy(); // Hancurkan sesi

// Redirect kembali ke halaman login
header("Location: login.php");
exit();
?>
