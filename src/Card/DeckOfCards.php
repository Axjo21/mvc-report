<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    protected $deck;

    public function __construct()
    {
        $this->deck = [
                '🂡',
                '🂢',
                '🂣',
                '🂤',
                '🂥',
                '🂦',
                '🂧',
                '🂨',
                '🂩',
                '🂪',
                '🂫',
                '🂬',
                '🂭',
                '🂮',
                '🂱'
            ];
    }


    public function getValues(): array
    {
        $values = [];
        foreach ($this->deck as $cards) {
            $values[] = $cards;
        }
        return $values;
    }

    public function shuffleDeck(): void
    {
        //$myDeck = $this->getValues();
        shuffle($this->deck);
    }







    public function draw(): int
    {
        $newCard = random_int(1, 10);
        return $newCard;
    }

    public function add(Card $cards): void
    {
        $this->deck[] = $cards;
    }

    public function getNumberCards(): int
    {
        return count($this->deck);
    }

}
