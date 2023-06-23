<?php 
session_start();
session_unset();
session_destroy();
echo "<script> alert('you are logged out !') </script>";
echo "<script> window.location.href = 'index.php' </script>";


?>