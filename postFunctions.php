<?php
function createCar($connection, $data, $image)
{
    $errors = array();
    $name = htmlspecialchars($data['name']);
    $model = htmlspecialchars($data['model']);
    $year = htmlspecialchars(intval($data['year']));
    $mileage = htmlspecialchars($data['mileage']);
    $city = htmlspecialchars($data['city']);
    $dtp = $data['dtp'];
    $color = htmlspecialchars($data['color']);
    $price = htmlspecialchars($data['price']);
    $phone = htmlspecialchars(intval($data['phone']));

    if ($image['name'] !== "") {

        $file_name = strtolower($_FILES["image"]["name"]);
        $file_size = $_FILES["image"]["size"];
        $file_type = $_FILES["image"]["type"];
        $file_tmp_name = $_FILES["image"]["tmp_name"];
        $file_size = $_FILES["image"]["size"];

        $allowed_types = array("image/jpeg", "image/png");

        if (!in_array($file_type, $allowed_types)) {
            $errors[] = "Invalid image format. Please upload a JPEG or PNG image.";
        }
        $max_file_size = 5 * 1024 * 1024;
        if ($file_size > $max_file_size) {
            $errors[] = "Image size exceeds the maximum allowed limit of 5MB.";
        }
        if (empty($errors)) {
            move_uploaded_file($file_tmp_name, "./img/" . $file_name);
            echo "Success";
        }
    };
    if (empty($errors)) {
        $query = "INSERT INTO `auto_details` (`name`, `model`, `year`, `mileage`, `city`, `color`, `dtp`, `price`, `phone_number`, `image`) 
                  VALUES ('$name', '$model', '$year', '$mileage', '$city', '$color', '$dtp', '$price', '$phone', '$file_name')";

        if (mysqli_query($connection, $query)) {
            http_response_code(201);
            $res = [
                "status" => true,
                "message" => "Car record created successfully!",
            ];
            echo json_encode($res);
        } else {
            http_response_code(500);
            $res = [
                "status" => false,
                "error" => mysqli_error($connection),
            ];
            echo json_encode($res);
        }
    } else {
        http_response_code(400);
        $res = [
            "status" => false,
            "errors" => $errors,
        ];
        echo json_encode($res);
    }
}


function addImageToCar($connection, $car_id, $image)
{
    $id = intval($car_id);
    $errors = array();
    if (isset($image['name']) && $image['name'] !== "") {
        $file_name = strtolower($_FILES["image"]["name"]);
        $file_size = $_FILES["image"]["size"];
        $file_type = $_FILES["image"]["type"];
        $file_tmp_name = $_FILES["image"]["tmp_name"];
        $file_size = $_FILES["image"]["size"];

        $allowed_types = array("image/jpeg", "image/png");

        if (!in_array($file_type, $allowed_types)) {
            $errors[] = "Invalid image format. Please upload a JPEG or PNG image.";
        }
        $max_file_size = 5 * 1024 * 1024;
        if ($file_size > $max_file_size) {
            $errors[] = "Image size exceeds the maximum allowed limit of 5MB.";
        }
        if (empty($errors)) {
            move_uploaded_file($file_tmp_name, "./img/" . $file_name);
            $res = [
                "status" => "Success"
            ];
            echo json_encode($res);
        } else {
            http_response_code(500);
            $res = [
                "status" => false,
                "error" => "Error uploading the file"
            ];
            echo json_encode($res);
            return;
        }
    }
    $stmt = mysqli_prepare($connection, "INSERT INTO `auto_images` (`id`, `auto_id`, `image`) VALUES (NULL, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'is', $id, $file_name);
    mysqli_stmt_execute($stmt);
    $newImage = mysqli_stmt_get_result($stmt);

    if ($newImage) {
        http_response_code(201);
        $res = [
            "status" => true,
            "post_id" => mysqli_insert_id($connection),
        ];
    } else {
        http_response_code(500);
        $res = [
            "status" => false,
            "error" => mysqli_error($connection),
        ];
    }

    echo json_encode($res);
}
