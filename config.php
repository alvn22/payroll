<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'sipeka';

    $con = mysqli_connect($host, $user, $pass, $db);

    if(!$con){
        die("Cannot Connect to Database ".mysqli_connect_error());
    }
?>