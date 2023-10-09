<?php

class CarsPostModel
{
    private $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance()->getConnection();
    }
    public function createCar($data)
    {

        $stmt =  $this->db->prepare("INSERT INTO `auto_details` (`name`, `model`, `year`, `mileage`, `city`, `color`, `dtp`, `price`, `phone_number`, `image`) 
                  VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$data["name"], $data["model"], $data["year"], $data["mileage"], $data["city"], $data["color"], $data["dtp"], $data["price"], $data["phone"], $data["file_name"]]);
        http_response_code(201);
        $res = [
            "status" => true,
            "message" => "Car record created successfully!",
        ];
        echo json_encode($res);
    }

    public function addImageToCar($id, $file_name)
    {
        print_r($file_name);
        $stmt = $this->db->prepare("INSERT INTO `auto_images` (`id`, `auto_id`, `image`) VALUES (NULL, ?, ?)");
        $stmt->execute([$id, $file_name]);




        http_response_code(201);
        $res = [
            "status" => true,
            "message" => "image add successful",

        ];
        echo json_encode($res);
    }
    public function addMoreFunctional($data)
    {
        $stmt = $this->db->prepare("INSERT INTO `auto_fynctionalitty` (`id`, `auto_id`, `engine_power`, `hp`, `engine_type`, `fuel_use_race`, `fuel_use_city`, `fuel_use_average`, `transmittion`, `drive_unit`, `descr`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->execute([$data["id"], $data["engine_power"], $data["hp"], $data["engine_type"], $data["fuel_use_race"], $data["fuel_use_city"], $data["fuel_use_average"], $data["transmittion"], $data["drive_unit"], $data["descr"]]);

        http_response_code(201);
        $res = [
            "status" => true,
            "message" => "Add new functional",
        ];
        echo json_encode($res);
    }
}
