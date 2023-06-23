<?php 
include "config.php";
session_start();
if(!isset($_SESSION['id'])){


    echo "<script> window.location.href = 'index.php' </script>";

}
if(isset($_GET['id'])){
$id = $_GET['id'];


$query = "DELETE FROM `tasks` WHERE `tasks`.`id` = $id";
if(mysqli_query($conn , $query)){
    echo "<script> alert('Task deleted') </script>";
    echo "<script> window.location.href = 'task.php' </script>";
    }

}



?>