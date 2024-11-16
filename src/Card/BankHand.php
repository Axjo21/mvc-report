<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\DeckOfCards;

class BankHand extends CardHand
{
    public DeckOfCards $deck;
    public ?string $name;

    // initierar DeckOfCards
    // behövs eftersom det är den klassen som faktiskt drar ett kort
    public function __construct(DeckOfCards $deck, ?string $name="Bank")
    {
        $this->deck = $deck;
        $this->name = $name;
    }



    /**
     * Drar kort genom att anropa DeckOfCards.drawCard();
     *
     * @return BetterCard[]
     */
    public function drawCards(): array
    {
        // for loop logic for how many to be drawn
        $score = 0;
        while ($score <= 17) {
            $drawnCard = $this->deck->drawCard();
            $this->add($drawnCard);
            $score = $this->getPoints();
        }

        return $this->hand;
    }

    /**
     * Drar resterande kort.
     *
     * @return BetterCard[]
     */
    public function executeTurn(): array
    {
        // for loop logic for how many to be drawn
        $score = $this->getPoints();
        while ($score <= 17) {
            $drawnCard = $this->deck->drawCard();
            $this->add($drawnCard);
            $score = $this->getPoints();
        }

        return $this->hand;
    }
}
