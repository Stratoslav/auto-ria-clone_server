<?php

function getCars($connection)
{


    $cars = mysqli_query($connection, "SELECT * FROM `auto_details`");

    $carList = [];

    while ($car = mysqli_fetch_assoc($cars)) {
        $carList[] = $car;
    }
    echo json_encode($carList);
}

function getOneCar($connection, $id)
{   
    $car = mysqli_query($connection, "SELECT * FROM  `auto_details` WHERE `id` = $id");
  
  
    $numRows = mysqli_num_rows($car);
    if ($numRows === 0) {
        http_response_code(404);
        $res = [
            "Message" => "no such car"
        ];
        echo json_encode($res);
    }

    $car = mysqli_fetch_assoc($car);
    echo json_encode($car);
}




function filterCar($connection, $value)
{
    $name = $value['search'];
    if (empty($name)) {
        http_response_code(400);
        $res = [
            "status" => false,
            "message" => "You need to fill in the input",
        ];
        echo json_encode($res);
        return;
    }
    $stmt = mysqli_prepare($connection, "SELECT * FROM `auto_details` WHERE `name` LIKE ? OR `model` LIKE ?");
    $nameWildcard = "%$name%";
    mysqli_stmt_bind_param($stmt, 'ss', $nameWildcard, $nameWildcard);
    mysqli_stmt_execute($stmt);
    $searchCars = mysqli_stmt_get_result($stmt);
    $carList = [];
    while ($searchCar = mysqli_fetch_assoc($searchCars)) {
        $carList[] = $searchCar;
    }
    echo json_encode($carList);
}


function selectCarByYear($connection, $data)
{
    $from = $data['from'];
    $to = $data['to'];

    $stmt = mysqli_prepare($connection, "SELECT * FROM `auto_details` WHERE `year` >= ? AND `year` <= ?");
    mysqli_stmt_bind_param($stmt, "ss", $from, $to);
    mysqli_stmt_execute($stmt);
    $selected = mysqli_stmt_get_result($stmt);

    $selectedList = [];
    while ($select = mysqli_fetch_assoc($selected)) {
        $selectedList[] = $select;
    }
    echo json_encode($selectedList);
}


function getFilterCarFromTo($connection, $data)
{
    $sortLike = intval($data['like']);
    if ($sortLike == 0) {
        $selected = mysqli_query($connection, "SELECT * FROM `auto_details` ORDER BY `price` DESC");
        $selectedList = [];
        while ($select = mysqli_fetch_assoc($selected)) {
            $selectedList[] = $select;
        }
        echo json_encode($selectedList);
    } else if ($sortLike == 1) {
        $selected = mysqli_query($connection, "SELECT * FROM `auto_details` ORDER BY `price` ASC");
        $selectedList = [];
        while ($select = mysqli_fetch_assoc($selected)) {
            $selectedList[] = $select;
        }
        echo json_encode($selectedList);
    } else {
        http_response_code(400);
        $res = [
            "status" => false,
            "message" => "OOps, something went wrong :("
        ];
        echo json_encode($res);
        return;
    }
}

function getCarImages($connection, $id)
{
    $id = intval($id);
    $stmt = mysqli_prepare($connection, "SELECT * FROM `auto_images` WHERE `auto_id` = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $allImages = mysqli_stmt_get_result($stmt);

    $imageList = [];
    while ($image = mysqli_fetch_assoc($allImages)) {
        $imageList[] = $image;
    }
    echo json_encode($imageList);
}
