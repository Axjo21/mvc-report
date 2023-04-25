<?php

namespace App\Card;

class Card
{

    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
