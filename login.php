<?php
include "config.php";
session_start();

if(isset($_POST['login'])){
    $name = $_POST['name'];
    $pass = $_POST['password'];
    
    $query = "SELECT * FROM `users` WHERE `userName` = '$name' AND `password` = '$pass' ";
    $res = mysqli_query($conn,$query);


    if(mysqli_num_rows($res) == 1 ){

    $user = mysqli_fetch_assoc($res);
    
    $userName = $user['userName'];
    $userID = $user['id'];
    $_SESSION['user'] = $userName;
    $_SESSION['id'] = $userID;

        echo "<script> alert('Login Successfull') </script>";
        echo "<script> window.location.href = 'task.php' </script>";
    }else{
        echo "<script> alert('Please Enter Correct email and Password !') </script>";
        echo "<script> window.location.href = 'index.php' </script>";
    }
    
    

}
?>