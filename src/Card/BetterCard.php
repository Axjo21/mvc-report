<?php

namespace App\Card;

class BetterCard extends Card
{
    public function __construct($value, $suit, $points)
    {
        parent::__construct($value, $suit, $points);
        #$this->$style = $style;
        #echo($this->$style);
    }

    public function setValue($newVal)
    {
        $this->value = $newVal;
    }

    public function setPoints($newPoints)
    {
        $this->points = $newPoints;
    }

    public function getPoints(): int
    {
        return $this->points;
    }
}
