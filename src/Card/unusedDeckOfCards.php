<?php

namespace App\Card;

use App\Card\Card;
use App\Card\BetterCard;

class unusedDeckOfCards extends BetterCard
{
    protected $deck;

    public function __construct()
    {
        $spades = ['🂡', '🂢', '🂣', '🂤', '🂥', '🂦', '🂧', '🂨', '🂩', '🂪', '🂫', '🂭', '🂮'];
        $hearts = ['🂱', '🂲', '🂳', '🂴', '🂵', '🂶', '🂷', '🂸', '🂹', '🂺', '🂻', '🂽', '🂾'];
        $diamonds = ['🃁', '🃂', '🃃', '🃄', '🃅', '🃆', '🃇', '🃈', '🃉', '🃊', '🃋', '🃍', '🃎'];
        $clovers = ['🃑', '🃒', '🃓', '🃔', '🃕', '🃖', '🃗', '🃘', '🃙', '🃚', '🃛', '🃝', '🃞'];
        $ourDeck = array();
        for ($i = 0; $i <= count($spades); ++$i) {
            $card = parent::__construct($spades[$i], 'spades');
            array_push($ourDeck, $card);
        };
        for ($i = 0; $i <= count($hearts); $i++) {
            array_push($ourDeck, new BetterCard($hearts[$i], 'hearts'));
        };        
        for ($i = 0; $i <= count($diamonds); $i++) {
            array_push($ourDeck, new BetterCard($diamonds[$i], 'diamonds'));
        };        
        for ($i = 0; $i <= count($clovers); $i++) {
            array_push($ourDeck, new BetterCard($clovers[$i], 'clovers'));
        };
        $this->deck = $ourDeck;
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
