<?php

namespace App\Card;

class BetterCard extends Card
{
    public function __construct($value, $suit)
    {
        parent::__construct($value, $suit);
        #$this->$style = $style;
        #echo($this->$style);
    }

    public function setValue($newVal)
    {
        $this->value = $newVal;
    }
}
