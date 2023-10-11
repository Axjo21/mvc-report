<?php

namespace App\Card;

class Card
{
    protected $value;
    public $suit;
    public function __construct($value, $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
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
