<?php

namespace App\Card;

use App\Card\Card;

class oldDeckOfCards
{
    protected $deck;

    public function __construct()
    {
        $this->deck = [
            '🂡', '🂢', '🂣', '🂤', '🂥', '🂦', '🂧', '🂨', '🂩', '🂪', '🂫', '🂭', '🂮',
            '🂱', '🂲', '🂳', '🂴', '🂵', '🂶', '🂷', '🂸', '🂹', '🂺', '🂻', '🂽', '🂾',
            '🃁', '🃂', '🃃', '🃄', '🃅', '🃆', '🃇', '🃈', '🃉', '🃊', '🃋', '🃍', '🃎',
            '🃑', '🃒', '🃓', '🃔', '🃕', '🃖', '🃗', '🃘', '🃙', '🃚', '🃛', '🃝', '🃞'
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

    public function drawCard(): string
    {
        //$someValue = random_int(1, 14);
        //$newCard = $this->deck[$someValue];
        $this -> shuffleDeck();
        $newCard = $this->deck[0];
        //if (($key = array_search($newCard, $this->deck)) !== false) {
        unset($this->deck[0]);
        //}
        return $newCard;
    }

    public function remove($card): void
    {
        if (($key = array_search($card, $this->deck)) !== false) {
            unset($this->deck[$key]);
        }
    }


    public function getNumberCards(): int
    {
        return count($this->deck);
    }

}
