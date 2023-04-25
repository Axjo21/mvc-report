<?php

namespace App\Card;

class BetterCard extends Card
{
    public function __construct($value)
    {
        parent::__construct($value);
    }

    public function setValue($newVal)
    {
        $this->value = $newVal;
    }
}
