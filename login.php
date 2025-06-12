<?php
    session_start();
    require("config.php");
    require("essentials.php");

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $q = "SELECT * FROM `user` WHERE `username`='$username' AND `password`='$password'";
        $r = mysqli_query($con,$q);
        if($r){
            $u = mysqli_fetch_assoc($r);
            if($u){
                $_SESSION['id'] = $u['id'];
                $_SESSION['nama'] = $u['nama'];
                $_SESSION['role'] = $u['role'];

                switch($u['role']){
                    case 'hr':
                        redirect('hr/index.php');
                        exit();
                    default:
                        echo "Unknown role.";
                        exit();
                }
            } else{
                echo"<script>alert('User tidak ditemukan!');</script>";
                redirect('index.php');
            }
        }
    }
?>