<?php

function updateCar($connection, $data, $id)
{
    $name = isset($data['name']) ? htmlspecialchars($data['name']) : "";
    $model = isset($data['model']) ? htmlspecialchars($data['model']) : '';
    $year = isset($data['year']) ? intval($data['year']) : 0;
    $mileage = isset($data['mileage']) ? htmlspecialchars($data['mileage']) : '';
    $city = isset($data['city']) ? htmlspecialchars($data['city']) : '';
    $dtp = isset($data['dtp']) ? $data['dtp'] : '';
    $color = isset($data['color']) ? htmlspecialchars($data['color']) : '';
    $price = isset($data['price']) ? htmlspecialchars($data['price']) : '';
    $phone = isset($data['phone']) ? intval($data['phone']) : 0;
    echo json_encode($data);
    $updated =   mysqli_query($connection, "UPDATE `auto_details` SET `name` = '$name', `model` = '$model', `year` = '$year', `mileage` = '$mileage', `city` = '$city', `color` = '$color', `dtp` = '$dtp', `price` = '$price', `phone_number` = '$phone' WHERE `auto_details`.`id` = $id");

    if ($updated) {
        http_response_code(200);
        $res = [
            "status" => true,
            "message" => "Post is update"
        ];
    } else {
        error_log("Error updating car: " . mysqli_error($connection));
        http_response_code(500);
        $res = [
            "status" => false,
            "message" => "Failed to update car. Please try again later.",
        ];
    }
    echo json_encode($res);
}
