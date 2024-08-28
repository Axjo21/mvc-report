<?php

namespace App\Card;

/**
 * En avskalad klass som hanterar värde och detaljer tillhörande korten.
 */
class Card
{
    protected string $value;
    public string $suit;
    public int $points;
    /**
     * Construct the values
     */
    public function __construct(string $value, string $suit, int $points)
    {
        $this->value = $value;
        $this->suit = $suit;
        $this->points = $points;
    }

    /**
     * Get value
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get value and suit as items in an array
     * @return string[]
     */
    public function getDetails(): array
    {
        return [$this->value, $this->suit];
    }
}
