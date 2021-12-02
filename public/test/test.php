<?php

class Test
{
    public $productName; 
    public $color; 

    private function __construct($productName, $color)
    {
        $this->productName = $productName; 
        $this->color =$color;
    }

    function __toString()
    {
        return "
            productName : {$this->productName} <br>
            color : {$this->color} <br>
        ";

    }

    public static function GenerateObj($productName, $color )
    {
        return new Test($productName, $color);
    }

}


echo $test; 
