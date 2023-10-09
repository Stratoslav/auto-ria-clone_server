<?php

class CarsModel
{
    private $db;

    public function __construct()
    {
        $this->db =  DataBase::getInstance()->getConnection();
        try {
            $res = $this->db->prepare("SELECT 1 FROM `cars` LIMIT 1");
        } catch (\PDOException $e) {
            $this->createTable();
        }
    }
    public function createTable()
    {
    }
    public function getCars()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM `auto_details`");

            $carList = [];

            while ($car = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $carList[] = $car;

                echo json_encode($carList);

                $stmt = $this->db->query("SELECT * FROM `auto_details`");

                $carList = [];

                while ($car = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $carList[] = $car;
                }
                echo json_encode($carList);
            }
        } catch (\PDOException $e) {
            echo $e;
        }
    }
    public function getOneCars($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM  `auto_details` WHERE `id` = ?");
            $car = $stmt->execute([$id]);
            $car = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($car === 0) {
                http_response_code(404);
                $res = [
                    "Message" => "no such car"
                ];
                echo json_encode($res);
            }

            echo json_encode($car);
        } catch (\PDOException $e) {
            echo $e;
        }
    }
    public function filterCar($name)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM `auto_details` WHERE `name` LIKE ? OR `model` LIKE ?");
            $nameWildcard = "%$name%";
            $stmt->execute([$nameWildcard, $nameWildcard]);

            $carList = [];
            while ($searchCar = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $carList[] = $searchCar;
            }
            echo json_encode($carList);
        } catch (\PDOException $e) {
            echo $e;
        }
    }
    public function selectCarByYear($from, $to)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM `auto_details` WHERE `year` >= ? AND `year` <= ?");
            $stmt->execute([$from, $to]);

            $selectedList = [];
            while ($select = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $selectedList[] = $select;
            }
            echo json_encode($selectedList);
        } catch (\PDOException $e) {
            echo $e;
        }
    }

    public function selectCarByPrice($from, $to)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM `auto_details` WHERE `price` >= ? AND `price` <= ?");
            $stmt->execute([$from, $to]);


            $selectedList = [];
            while ($select = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $selectedList[] = $select;
            }
            echo json_encode($selectedList);
        } catch (\PDOException $e) {
            echo $e;
        }
    }
    public function getFilterCarFromTo($sortLike)
    {
        try {
            if ($sortLike == 0) {
                $stmt = $this->db->query("SELECT * FROM `auto_details` ORDER BY `price` DESC");
                $selectedList = [];
                while ($select = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $selectedList[] = $select;
                }
                echo json_encode($selectedList);
            } else if ($sortLike == 1) {
                $stmt = $this->db->query("SELECT * FROM `auto_details` ORDER BY `price` ASC");
                $selectedList = [];
                while ($select = $stmt->fetch(\PDO::FETCH_ASSOC)) {
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
        } catch (\PDOException $e) {
            echo $e;
        }
    }
    public function getCarImages($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM `auto_images` WHERE `auto_id` = ?");
            $stmt->execute([$id]);


            $imageList = [];
            while ($image = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $imageList[] = $image;
            }
            echo json_encode($imageList);
        } catch (\PDOException $e) {
            echo $e;
        }
    }
    function getCarDescription($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM `auto_fynctionalitty` WHERE `auto_id` = ?");
            $stmt->execute([$id]);


            $numRows = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($numRows === 0) {
                http_response_code(404);
                $res = [
                    "Message" => "no such car"
                ];
                echo json_encode($res);
            }

            echo json_encode($numRows);
        } catch (\PDOException $e) {
            echo $e;
        }
    }
}
