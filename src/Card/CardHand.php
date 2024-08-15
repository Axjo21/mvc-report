<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    protected $hand = [];

    public function add(BetterCard $card): void
    {
        $this->hand[] = $card;
    }

    public function getNumberCards(): int
    {
        return count($this->hand);
    }

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
