<?php

namespace App\Card;

use App\Card\Card;
use App\Card\BetterCard;

class CardHand
{
    /**
     * @var BetterCard[]
     */
    protected array $hand = [];

    public ?string $name = "";

    /**
     * Construct the values
     */
    public function __construct(?string $name = "")
    {
        $this->name = $name;
    }

    public function add(BetterCard $card): void
    {
        $this->hand[] = $card;
    }

    public function getNumberCards(): int
    {
        return count($this->hand);
    }

    /**
     * Såhär skriver man eftersom det returneras en array med arrayer som items
     * och de arrayerna har strings i dem.
     * @return String[][]
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getDetails();
        }
        return $values;
    }

    public function getPoints(): int
    {
        $points = 0;
        // count points
        foreach ($this->hand as $card) {
            $points += $card->getPoints();
        }
        // if more than 21
        if ($points > 21) {
            // check for ace
            foreach ($this->hand as $card) {
                // reassign ace value to 1 (from 14)
                if ($card->getPoints() === 14) {
                    $card->setPoints(1);
                }
            }
            // recount
            $points = 0;
            foreach ($this->hand as $card) {
                $points += $card->getPoints();
            }
        }
        return $points;
    }
}
