<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\DeckOfCards;

class BankHand extends CardHand
{
    public DeckOfCards $deck;

    // initierar DeckOfCards
    // behövs eftersom det är den klassen som faktiskt drar ett kort
    public function __construct(DeckOfCards $deck)
    {
        $this->deck = $deck;
    }



    /**
     * Drar kort genom att anropa DeckOfCards.drawCard();
     *
     * @return BetterCard[]
     */
    public function drawCards(): array
    {
        // for loop logic for how many to be drawn

        // dra ett kort
        $score = 0;

        while ($score <= 17) {
            $drawnCard = $this->deck->drawCard();
            $this->add($drawnCard);
            $score = $this->getPoints();
        }
        /*
        $drawnCard = $this->deck->drawCard();
        $this->add($drawnCard);
        // dra ett till
        $secondDrawnCard = $this->deck->drawCard();
        $this->add($secondDrawnCard);
        */
        // här uppdaterar jag CardHand klassens "hand" attribut
        // denna klass har åtkomst till attributet eftersom det är
        // "protected" och inte "private" (eller "public" för den delen)
        return $this->hand;
    }
}
