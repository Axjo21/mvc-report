<?php

namespace App\Card;

class CardOld
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getAsString(): string
    {
        return "{$this->value}";
    }
}
