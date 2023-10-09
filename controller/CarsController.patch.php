<?php


class CarsPatchController
{

    private $carsModel;

    public function __construct()
    {
        $this->carsModel = new CarsPatchModel();
    }

    public function updateCar($data, $id)
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

        $this->carsModel->updateCar(
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
        );
    }
}
