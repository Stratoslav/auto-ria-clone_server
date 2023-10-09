<?php

class CarsPostController
{

    private $carsController;

    public function __construct()
    {
        $this->carsController = new CarsPostModel();
    }
    public function createCar($data, $image)
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
            } else {
                http_response_code(400);
                $res = [
                    "status" => false,
                    "errors" => $errors,
                ];
                echo json_encode($res);
                exit();
            }
        };
        $dataArray = [
            'name' => $name,
            'model' => $model,
            'year' => $year,
            'mileage' => $mileage,
            'city' => $city,
            'color' => $color,
            'dtp' => $dtp,
            'price' => $price,
            'phone' => $phone,
            'file_name' => $file_name
        ];
        $this->carsController->createCar($dataArray);
    }

    public function addImageToCar($car_id, $image)
    {
        $id = intval($car_id);
        $errors = array();
        if (isset($image['name']) && $image['name'] !== "") {
            $file_name = strtolower($_FILES["image"]["name"]);
            $file_size = $_FILES["image"]["size"];
            $file_type = $_FILES["image"]["type"];
            $file_tmp_name = $_FILES["image"]["tmp_name"];
            $file_size = $_FILES["image"]["size"];

            $allowed_types = array("image/jpeg", "image/png", "image/jpg");

            if (!in_array($file_type, $allowed_types)) {
                $errors[] = "Invalid image format. Please upload a JPEG or PNG image.";
                exit();
            }
            $max_file_size = 5 * 1024 * 1024;
            if ($file_size > $max_file_size) {
                $errors[] = "Image size exceeds the maximum allowed limit of 5MB.";
                exit();
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
                exit();
            }
        }
        $this->carsController->addImageToCar($id, $file_name);
    }

    public  function addMoreFunctional($data, $car_id)
    {
        echo var_dump($car_id);
        $id = intval($car_id);
        $engine_power = intval($data['engine_power']);
        $engine_type = htmlspecialchars($data['engine_type']);
        $fuel_use_race = intval($data['fuel_use_race']);
        $fuel_use_city = intval($data['fuel_use_city']);
        $fuel_use_average = intval($data['fuel_use_average']);
        $hp = intval($data['hp']);
        $transmittion = htmlspecialchars($data['transmittion']);
        $descr = htmlspecialchars($data['descr']);
        $drive_unit = htmlspecialchars($data['drive_unit']);

        $dataArray = [

            'id' => $id,
            'engine_power' => $engine_power,
            'engine_type' => $engine_type,
            'fuel_use_race' => $fuel_use_race,
            'fuel_use_city' => $fuel_use_city,
            'fuel_use_average' => $fuel_use_average,
            'hp' => $hp,
            'transmittion' => $transmittion,
            'descr' => $descr,
            'drive_unit' => $drive_unit,
        ];
        $this->carsController->addMoreFunctional($dataArray);
    }
}
