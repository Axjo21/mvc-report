<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\DeckOfCards;

class BankHand extends CardHand
{
    public DeckOfCards $deck;
    public ?string $name;
    public ?BetterCard $hiddenCard;


    // initierar DeckOfCards
    // behövs eftersom det är den klassen som faktiskt drar ett kort
    public function __construct(DeckOfCards $deck, ?string $name = "Bank")
    {
        $this->deck = $deck;
        $this->name = $name;
        $this->hiddenCard = null;
    }


    public function setHiddenCard(BetterCard $card): void
    {
        $this->hiddenCard = $card;
        return;
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
     * Visar bankens gömda kort. 
     * Används när någon oväntat fått 21.
     *
     * @return void
     */
    public function showHiddenCard(): void
    {
        $this->hiddenCard !== null && $this->hand[0] = $this->hiddenCard;
        return;
    }


    /**
     * Drar resterande kort baserat på vad de andra spelarna har fått för poäng.
     * Parametern playerPoints representerar vad spelaren med högts poäng har för poäng.
     * @param array<int> $playersPoints
     * @return BetterCard[]
     */
    public function executeTurn(array $playersPoints): array
    {
        $this->hiddenCard !== null && $this->hand[0] = $this->hiddenCard;
        // hittar spelaren som har högst poäng som är under 21.
        $highestPoint = 0;
        foreach ($playersPoints as $point) {
            if ($point < 21 && $point > $highestPoint) {
                $highestPoint = $point;
            }
        }
        // drar kort tills banken har fler kort än de andra spelarna. 
        $score = $this->getPoints();

        while ($score < $highestPoint) {
            $drawnCard = $this->deck->drawCard();
            $this->add($drawnCard);
            $score = $this->getPoints();
        }

        return $this->hand;
    }
}
