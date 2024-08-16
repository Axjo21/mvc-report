<?php

namespace App\Card;

class Card
{
    protected string $value;
    public string $suit;
    public int $points;
    public function __construct(string $value, string $suit, int $points)
    {
        $this->value = $value;
        $this->suit = $suit;
        $this->points = $points;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string[]
     */
    public function getDetails(): array
    {
        return [$this->value, $this->suit];
    }
}
