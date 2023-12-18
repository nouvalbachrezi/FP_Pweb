<?php    
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "cpns";

    $connection = mysqli_connect($server, $user, $password, $database);

    if(!$connection) {
        die("Failed to connect to database: " . mysqli_connect_error());
    }
?>