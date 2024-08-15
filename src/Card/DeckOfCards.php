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
            new BetterCard('🂡', 'spades', 14), new BetterCard('🂢', 'spades', 2), new BetterCard('🂣', 'spades', 3), new BetterCard('🂤', 'spades', 4),
            new BetterCard('🂥', 'spades', 5), new BetterCard('🂦', 'spades', 6), new BetterCard('🂧', 'spades', 7), new BetterCard('🂨', 'spades', 8),
            new BetterCard('🂩', 'spades', 9), new BetterCard('🂪', 'spades', 10), new BetterCard('🂫', 'spades', 11), new BetterCard('🂭', 'spades', 12),
            new BetterCard('🂮', 'spades', 13)
        ];
        $hearts = [
            new BetterCard('🂱', 'hearts', 14), new BetterCard('🂲', 'hearts', 2), new BetterCard('🂳', 'hearts', 3), new BetterCard('🂴', 'hearts', 4),
            new BetterCard('🂵', 'hearts', 5), new BetterCard('🂶', 'hearts', 6), new BetterCard('🂷', 'hearts', 7), new BetterCard('🂸', 'hearts', 8),
            new BetterCard('🂹', 'hearts', 9), new BetterCard('🂺', 'hearts', 10), new BetterCard('🂻', 'hearts', 11), new BetterCard('🂽', 'hearts', 12),
            new BetterCard('🂾', 'hearts', 13)
        ];
        $clovers = [
            new BetterCard('🃑', 'clovers', 14), new BetterCard('🃒', 'clovers', 2), new BetterCard('🃓', 'clovers', 3), new BetterCard('🃔', 'clovers', 4),
            new BetterCard('🃕', 'clovers', 5), new BetterCard('🃖', 'clovers', 6), new BetterCard('🃗', 'clovers', 7), new BetterCard('🃘', 'clovers', 8),
            new BetterCard('🃙', 'clovers', 9), new BetterCard('🃚', 'clovers', 10), new BetterCard('🃛', 'clovers', 11), new BetterCard('🃝', 'clovers', 12),
            new BetterCard('🃞', 'clovers', 13)
        ];
        $diamonds = [
            new BetterCard('🃁', 'diamonds', 14), new BetterCard('🃂', 'diamonds', 2), new BetterCard('🃃', 'diamonds', 3), new BetterCard('🃄', 'diamonds', 4),
            new BetterCard('🃅', 'diamonds', 5), new BetterCard('🃆', 'diamonds', 6), new BetterCard('🃇', 'diamonds', 7), new BetterCard('🃈', 'diamonds', 8),
            new BetterCard('🃉', 'diamonds', 9), new BetterCard('🃊', 'diamonds', 10), new BetterCard('🃋', 'diamonds', 11), new BetterCard('🃍', 'diamonds', 12),
            new BetterCard('🃎', 'diamonds', 13)
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
