<?php

$connection = mysqli_connect('localhost', "root", "", "auto", "3306");

if (mysqli_errno($connection)) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$data =  mysqli_query($connection, "SELECT * FROM `auto_details`");

if ($data) {
    $parsedData =   mysqli_fetch_all($data);
}
