<?php


class CarsPatchModel
{
    private $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance()->getConnection();
    }

    public function updateCar(
        $name,
        $model,
        $year,
        $mileage,
        $city,
        $dtp,
        $color,
        $price,
        $phone,
        $id
    ) {
        try {
            $stmt =   $this->db->prepare("UPDATE `auto_details` SET `name` = ?, `model` = ?, `year` = ?, `mileage` = ?, `city` = ?, `color` = ?, `dtp` = ?, `price` = ?, `phone_number` = ? WHERE `auto_details`.`id` = ?");
            $updated = $stmt->execute([$name, $model, $year, $mileage, $city, $color, $dtp, $price, $phone, $id]);
            if ($updated) {
                http_response_code(200);
                $res = [
                    "status" => true,
                    "message" => "Post is update"
                ];
            } else {
                error_log("Error updating car: " . $this->db->errorInfo);
                http_response_code(500);
                $res = [
                    "status" => false,
                    "message" => "Failed to update car. Please try again later.",
                ];
            }
            echo json_encode($res);
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
