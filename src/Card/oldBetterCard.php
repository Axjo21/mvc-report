<?php

namespace App\Card;

class oldBetterCard extends Card
{
    public function __construct($value, $color)
    {
        parent::__construct($value, $color);
    }

    public function setValue($newVal)
    {
        $this->value = $newVal;
    }
}
