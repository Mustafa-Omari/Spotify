<?php 

    ob_start();
    session_start();

    $time_zone = date_default_timezone_set("Asia/Amman");

    $conn = mysqli_connect("localhost", "root", "", "spotify");

    if(mysqli_connect_errno())
        echo "Faild to connect: " . mysqli_connect_errno();

?>