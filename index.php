<?php
require_once "./headers.php";
require_once "./server/connection.php";
require_once "./getFunctions.php";
require_once "./patchFunctions.php";
require_once "./postFunctions.php";
require_once "./user/register.php";


$query = $_GET['q'];
$method = $_SERVER['REQUEST_METHOD'];
$params = explode("/", $query);
$type = $params[0];
$id = $params[1];
$car_id = $params[2];


if ($method === "GET") {
    if ($query === "cars") {

        getCars($connection);
    } else if (isset($_GET['from']) && isset($_GET['to'])) {

        selectCarByYear($connection, $_GET);
    } else if (isset($_GET['low']) && isset($_GET['big'])) {

        selectCarByPrice($connection, $_GET);
    } else if (isset($_GET['search'])) {

        filterCar($connection, $_GET);
    } else if (isset($_GET['like'])) {

        getFilterCarFromTo($connection, $_GET);
    } else if ($query === 'cars/get_images/' . $car_id) {

        getCarImages($connection, $car_id);
    } else if ($query === "cars/details/" . $car_id) {

        getCarDescription($connection, $car_id);
    } else if ($query === "cars/" . $id) {
        
        getOneCar($connection, $id);
    }
}

if ($method === "POST") {
    if ($query === "signin") {
        createUser($_POST, $connection);
       }   else if($query === "login"){
  
        login($connection, $_POST);
    }
    } else if ($query === "cars") {

        createCar($connection, $_POST, $_FILES['image']);
    } else if ($query === "cars/post_image/" . $car_id) {

        addImageToCar($connection, $car_id, $_FILES['image']);
    } else if ($query === "cars/add/" . $car_id) {

        addMoreFunctional($connection, $_POST, $car_id);
    
}
if ($method === "PATCH") {
    if ($query === "cars/" . $id) {
        $data = file_get_contents('php://input');

        $data = json_decode($data, true);

        updateCar($connection, $data, $id);
    }
}