<?php

require_once "./config.php";
require_once "./headers.php";
require_once "./model/DataBase.php";
require_once "./model/AuthModel.php";
require_once "./model/CarsModel.php";
require_once "./model/CarsModel.post.php";
require_once "./model/CarsModel.patch.php";
require_once "./controller/AuthController.php";
require_once "./controller/CarsController.php";
require_once "./controller/CarsController.post.php";
require_once "./controller/CarsController.patch.php";

$query = $_GET['q'];
$method = $_SERVER['REQUEST_METHOD'];
$params = explode("/", $query);
$type = $params[0];
$id = $params[1];
$car_id = $params[2];
$carsController = new CarsController();
$carsPostController = new CarsPostController();
$carsPatchController = new CarsPatchController();
switch ($method) {
    case 'GET':

        // switch ($query) {
        //     case "cars":
        //         getCars($connection);
        //         break;
        //     case 'cars/get_images/' . $car_id:
        //         getCarImages($connection, $car_id);
        //         break;
        //     case "cars/details/" . $car_id:
        //         getCarDescription($connection, $car_id);
        //         break;
        //     case "cars/" . $id;
        //         getOneCar($connection, $id);
        //         break;
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
                $carsPostController->createCar($_POST, $_FILES['image']);
                break;
            case "cars/post_image/" . $car_id:
                $carsPostController->addImageToCar($car_id, $_FILES['image']);
                break;
            case "cars/add/" . $car_id:
                $carsPostController->addMoreFunctional($_POST, $car_id);

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

                $carsPatchController->updateCar($data, $id);
                break;
        }
        break;
    default:
        echo "NOT FOUND";
        break;
}

if ($method === "GET") {
    if ($query === "cars") {

        $carsController->getCars();
    } else
    if (isset($_GET['from']) && isset($_GET['to'])) {

        $carsController->selectCarByYear($_GET);
    } else if (isset($_GET['low']) && isset($_GET['big'])) {

        $carsController->selectCarByPrice($_GET);
    } else if (isset($_GET['search'])) {

        $carsController->filterCar($_GET);
    } else if (isset($_GET['like'])) {

        $carsController->getFilterCarFromTo($_GET);
    } else if ($query === 'cars/get_images/' . $car_id) {

        $carsController->getCarImages($car_id);
    } else if ($query === "cars/details/" . $car_id) {

        $carsController->getCarDescription($car_id);
    } else if ($query === "cars/" . $id) {

        $carsController->getOneCar($id);
    }
}
