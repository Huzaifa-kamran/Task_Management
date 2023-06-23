<?php
include "config.php";


if(isset($_POST['register'])){
$name = $_POST['name'];
$email = $_POST['email'];
$pass = $_POST['password'];


if($name == "" || $email == "" || $pass == ""){

    echo "<script> alert('please fill all the form fields') </script>";

}else{
    $query = "INSERT INTO `users` (`userName`, `userEmail`, `password`) VALUES ('$name', '$email', '$pass')";
    $res = mysqli_query($conn, $query);
    
    if ($res){
        echo "<script> alert('Signup Successfully !') </script>";
        echo "<script> window.location.href = 'index.php' </script>";
    }else{
        echo "<script> alert('Error') </script>";
    }
}
    
}


?>