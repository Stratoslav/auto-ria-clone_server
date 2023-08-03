<?php
// INSERT INTO `auto_details` (`id`, `name`, `model`, `year`, `mileage`, `city`, `image`, `color`, `dtp`, `price`, `phone_number`) VALUES (NULL, 'mazda', '3', '2009', '36000', 'Ternopil', NULL, 'black', '0', '15000', '090767335');
$connection = mysqli_connect('localhost', "root", "", "auto", "3306");

if (mysqli_errno($connection)) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$data =  mysqli_query($connection, "SELECT * FROM `auto_details`");

if ($data) {
    $parsedData =   mysqli_fetch_all($data);
}
