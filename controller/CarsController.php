<?php

class CarsController
{

    private  $carsModel;

    public function  __construct()
    {
        $this->carsModel = new CarsModel();
    }
    public function getCars()
    {
        $this->carsModel->getCars();
    }

    public  function getOneCar($id)
    {
        $this->carsModel->getOneCars($id);
    }

    public function filterCar($value)
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
        $this->carsModel->filterCar($name);
    }


    public  function selectCarByYear($data)
    {
        $from = $data['from'];
        $to = $data['to'];
        if (empty($from) || empty($to)) {
            http_response_code(400);
            $res = [
                "status" => false,
                "message" => "You need to fill in the input",
            ];
            echo json_encode($res);
            return;
        }
        $this->carsModel->selectCarByYear($from, $to);
    }


    public function selectCarByPrice($data)
    {
        $from = htmlspecialchars(intval($data['low']));
        $to = htmlspecialchars(intval($data['big']));

        if (empty($from) || empty($to)) {
            http_response_code(400);
            $res = [
                "status" => false,
                "message" => "Price must be more than 0$",
            ];
            echo json_encode($res);
            return;
        }
        $this->carsModel->selectCarByPrice($from, $to);
    }

    function getFilterCarFromTo($data)
    {
        $sortLike = intval($data['like']);
        $this->carsModel->getFilterCarFromTo($sortLike);
    }
    function getCarImages($id)
    {
        $id = intval($id);
        $this->carsModel->getCarImages($id);
    }
    function getCarDescription($id)
    {
        $id = intval($id);
        $this->carsModel->getCarDescription($id);
    }
}
