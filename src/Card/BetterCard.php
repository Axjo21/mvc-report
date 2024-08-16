<?php

namespace App\Card;

class BetterCard extends Card
{
    public function __construct(string $value, string $suit, int $points)
    {
        parent::__construct($value, $suit, $points);
        #$this->$style = $style;
        #echo($this->$style);
    }

    public function setValue(string $newVal): void
    {
        $this->value = $newVal;
    }

    public function setPoints(int $newPoints): void
    {
        $this->points = $newPoints;
    }

    public function getPoints(): int
    {
        return $this->points;
    }
}
