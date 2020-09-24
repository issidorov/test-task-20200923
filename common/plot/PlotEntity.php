<?php


namespace common\plot;


class PlotEntity
{
    public $number;
    public $address;
    public $price;
    public $area;

    public function __construct(string $number, string $address, float $price, float $area)
    {
        $this->number = $number;
        $this->address = $address;
        $this->price = $price;
        $this->area = $area;
    }
}