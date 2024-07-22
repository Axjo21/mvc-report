<?php

namespace App\Card;

use App\Card\Card;
use App\Card\BetterCard;

class DeckOfCards extends BetterCard
{
    protected $deck;

    public function __construct()
    {
        $spades = [
            new BetterCard('🂡', 'spades'), new BetterCard('🂢', 'spades'), new BetterCard('🂣', 'spades'), new BetterCard('🂤', 'spades'),
            new BetterCard('🂥', 'spades'), new BetterCard('🂦', 'spades'), new BetterCard('🂧', 'spades'), new BetterCard('🂨', 'spades'),
            new BetterCard('🂩', 'spades'), new BetterCard('🂪', 'spades'), new BetterCard('🂫', 'spades'), new BetterCard('🂭', 'spades'),
            new BetterCard('🂮', 'spades')
        ];
        $hearts = [
            new BetterCard('🂱', 'hearts'), new BetterCard('🂲', 'hearts'), new BetterCard('🂳', 'hearts'), new BetterCard('🂴', 'hearts'),
            new BetterCard('🂵', 'hearts'), new BetterCard('🂶', 'hearts'), new BetterCard('🂷', 'hearts'), new BetterCard('🂸', 'hearts'),
            new BetterCard('🂹', 'hearts'), new BetterCard('🂺', 'hearts'), new BetterCard('🂻', 'hearts'), new BetterCard('🂽', 'hearts'),
            new BetterCard('🂾', 'hearts')
        ];
        $clovers = [
            new BetterCard('🃑', 'clovers'), new BetterCard('🃒', 'clovers'), new BetterCard('🃓', 'clovers'), new BetterCard('🃔', 'clovers'),
            new BetterCard('🃕', 'clovers'), new BetterCard('🃖', 'clovers'), new BetterCard('🃗', 'clovers'), new BetterCard('🃘', 'clovers'),
            new BetterCard('🃙', 'clovers'), new BetterCard('🃚', 'clovers'), new BetterCard('🃛', 'clovers'), new BetterCard('🃝', 'clovers'),
            new BetterCard('🃞', 'clovers')
        ];
        $diamonds = [
            new BetterCard('🃁', 'diamonds'), new BetterCard('🃂', 'diamonds'), new BetterCard('🃃', 'diamonds'), new BetterCard('🃄', 'diamonds'),
            new BetterCard('🃅', 'diamonds'), new BetterCard('🃆', 'diamonds'), new BetterCard('🃇', 'diamonds'), new BetterCard('🃈', 'diamonds'),
            new BetterCard('🃉', 'diamonds'), new BetterCard('🃊', 'diamonds'), new BetterCard('🃋', 'diamonds'), new BetterCard('🃍', 'diamonds'),
            new BetterCard('🃎', 'diamonds')
        ];
        #$hearts = [ '🂵', '🂶', '🂷', '🂸', '🂹', '🂺', '🂻', '🂽', '🂾'];
        #$diamonds = ['🃁', '🃂', '🃃', '🃄', '🃅', '🃆', '🃇', '🃈'];

        #$clovers = ['🃖', '🃗', '🃘', '🃙', '🃚', '🃛', '🃝', '🃞'];
        #$ourDeck = $spades;
        $this->deck = array_merge($spades, $hearts, $clovers, $diamonds);
    }

    public function getCards(): array
    {
        $values = [];
        foreach ($this->deck as $cards) {
            $values[] = $cards;
        }
        return $values;
    }

    public function getValues(): array
    {
        $values = [];
        foreach ($this->deck as $cards) {
            $values[] = $cards->value;
        }
        return $values;
    }

    public function getSuit($value): array
    {
        $colors = [];
        foreach ($this->deck as $cards) {
            $suits[] = $cards->suit;
        }
        return $suits;
    }

    public function shuffleDeck(): void
    {
        //$myDeck = $this->getValues();
        shuffle($this->deck);
    }

    public function drawCard(): BetterCard
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

    public function apiDraw(): BetterCard
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
