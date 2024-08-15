<?php

namespace App\Card;

class Card
{
    protected $value;
    public $suit;
    public $points;
    public function __construct($value, $suit, $points)
    {
        $this->value = $value;
        $this->suit = $suit;
        $this->points = $points;
    }

    public function getValue(): string
    {
        return $this->value;
    }
    public function getDetails(): array
    {
        return [$this->value, $this->suit];
    }
}
