<?php
session_start();

// Hapus sesi
session_destroy();

// Redirect ke halaman login
header("Location: ../login.php");
exit;  
?>
