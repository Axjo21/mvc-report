<?php

namespace App\Card;

use App\Card\CardHand;

/**
 * En Node klass för spelare i Black Jack.
 * Instanser av noder lägs i PlayerQueue klassen för att skapa en linked list.
 */
class Node
{
    public CardHand $data;
    public ?Node $next;
    public ?bool $bank;
    public int $betPool;


    /**
     * Construct the values
     */
    public function __construct(CardHand $data)
    {
        $this->data = $data;
        $this->next = null;
        $this->bank = false;
        $this->betPool = 0;
    }


    /**
     * Get data
     * @return CardHand
     */
    public function getData(): CardHand
    {
        return $this->data;
    }


    /**
     * Set data
     * @return void
     */
    public function setData(CardHand $data): void
    {
        $this->data = $data;
    }


    /**
     * Set next
     * @return Node
     */
    public function getNext(): Node
    {
        return $this->next;
    }


    /**
     * Set next
     * @return void
     */
    public function setNext(string $next): void
    {
        $this->next = $next;
    }

    /**
     * Place a bet.
     * @return void
     */
    public function placeBet(int $placedBet): void
    {
        $this->betPool += $placedBet;
    }

    /**
     * Get bets
     * @return int
     */
    public function getBetPool(): int
    {
        return $this->betPool;
    }






}
