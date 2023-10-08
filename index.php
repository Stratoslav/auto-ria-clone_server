<?php

require_once "./config.php";
require_once "./headers.php";
require_once "./server/connection.php";
require_once "./getFunctions.php";
require_once "./patchFunctions.php";
require_once "./postFunctions.php";
require_once "./model/DataBase.php";
require_once "./model/AuthModel.php";
require_once "./controller/AuthController.php";

$query = $_GET['q'];
$method = $_SERVER['REQUEST_METHOD'];
$params = explode("/", $query);
$type = $params[0];
$id = $params[1];
$car_id = $params[2];


switch ($method) {
    case 'GET':
        // switch($query){
        //     case "cars":

        // }
        break;
    case "POST":
        switch ($query) {
            case 'signin':
                $controller = new AuthController();
                $controller->register($_POST);
                break;
            case 'login':
                $controller = new AuthController();
                $controller->login($_POST);
                break;
            case 'cars':
                createCar($connection, $_POST, $_FILES['image']);
                break;
            case "cars/post_image/" . $car_id:
                addImageToCar($connection, $car_id, $_FILES['image']);
                break;
            case "cars/add/" . $car_id:
                addMoreFunctional($connection, $_POST, $car_id);
                break;
            default:
                echo "not found";
                break;
        }
        break;
    case "PATCH":
        switch ($query) {
            case "cars/" . $id:
                $data = file_get_contents('php://input');

                $data = json_decode($data, true);

                updateCar($connection, $data, $id);
                break;
        }
        break;
    default:
        echo "NOT FOUND";
        break;
}

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

// if ($method === "POST") {
//     if ($query === "signin") {
//           $controller = new AuthController();
//         $controller->register($_POST);
//        }   else if($query === "login"){
//         $controller = new AuthController();
//         $controller->login($_POST);

//     }
//     } else if ($query === "cars") {

//         createCar($connection, $_POST, $_FILES['image']);
//     } else if ($query === "cars/post_image/" . $car_id) {

//         addImageToCar($connection, $car_id, $_FILES['image']);
//     } else if ($query === "cars/add/" . $car_id) {

//         addMoreFunctional($connection, $_POST, $car_id);

// }
// if ($method === "PATCH") {
//     if ($query === "cars/" . $id) {
//         $data = file_get_contents('php://input');

//         $data = json_decode($data, true);

//         updateCar($connection, $data, $id);
//     }
// }