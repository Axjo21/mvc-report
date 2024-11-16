<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\Node;

/**
 * En helper klass för BlackJack.
 */
class LinkedList
{
    public ?Node $head;
    public DeckOfCards $deck;
    public int $numberOfPlayers;
    public int $turn;
    public ?Node $winner;


    /**
     * Construct the values
     */
    public function __construct()
    {
        $this->head = null;
        $this->deck = new DeckOfCards;
        $this->numberOfPlayers = 0;
        $this->turn = 0;
        $this->winner = null;
    }


    /**
     * Advances the queue so that it is the next players turn. 
     * @return void
     */
    public function advanceQueue(): void
    {
        $this->turn += 1;
    }

    /**
     * Performs a check and returns a boolean for wether or not
     * each player has already had their turn.
     * @return bool
     */
    public function banksTurn(): bool
    {
        $current = $this->head;
        $counter = 0;
        while ($current !== null) {
            $current = $current->next;
            $counter++;
        }
        return $this->turn === $counter;
    }


    /**
     * Add player node to the linked list.
     * @return void
     */
    public function addPlayer(string $name, ?bool $bank=false): void
    {
        // init hand
        if ($bank) {
            $hand = new BankHand($this->deck, $name);
            $firstCard = $this->deck->drawCard();
            $secondCard = $this->deck->drawCard();
            
            $hand->add($firstCard);
            $hand->add($secondCard);
            $node = new Node($hand);
            $node->bank = true;
        } else {
            $hand = new CardHand($name);
            $firstCard = $this->deck->drawCard();
            $secondCard = $this->deck->drawCard();
            
            $hand->add($firstCard);
            $hand->add($secondCard);
            $node = new Node($hand);
        }

        // create node with hand as data
        if ($this->head === null) {
            $this->head = $node;
            return;
        }

        $current = $this->head;
        while ($current->next !== null) {
            $current = $current->next;
        }
        $current->next = $node;


        $this->numberOfPlayers += 1;
    }


    /**
     * Check if there is a winner.
     * @return ?array
     */
    public function getScores(): ?Node
    {

        $current = $this->head;
        $points = [];

        // loop through until you find the matching index
        while ($current !== null) {
            if ($current->data->getPoints() === 21) {
                $this->winner = $current;
                return $current;
            }
            array_push($points, $current->data->getPoints());
            $current = $current->next;
        }

        // returns null if there is no match
        return null;
    }


    /**
     * Get player node through their index in the linked list. 
     * @return ?Node
     */
    public function getPlayerThroughIndex(int $index): ?Node
    {

        $current = $this->head;
        $count = 0;

        // loop through until you find the matching index
        while ($current !== null) {
            if ($count === $index) {
                return $current->data;
            }
            $count++;
            $current = $current->next;
        }

        // returns null if there is no match
        return null;
    }



    /**
     * Return all nodes player-data in a list. 
     * @return ?array
     */
    public function getPlayerDataAsArray(): ?array
    {
        $current = $this->head;
        if ($current === null) {
            return [];
        }

        $playerList = [];
        $counter = 0;
        // loop through until all nodes have been traversed.
        while ($current !== null) {
            if ($current->data->getPoints() > 21 && $counter === $this->turn) {
                $this->advanceQueue();
            }
            $playerData = [
                "name" => $current->data->name,
                "cards" => $current->data->getValues(),
                "points" => $current->data->getPoints(),
                "playersTurn" => $this->turn === $counter,
                "bank" => $current->bank
            ];          // bool for if it's players turn
            array_push($playerList, $playerData);


            $current = $current->next;
            $counter++;
        }

        return $playerList;
    }



    /**
     * Draw a card for the player att certain index.
     * @return ?Node
     */
    public function drawCardForCurrentPlayer(): ?Node
    {

        $current = $this->head;
        $count = 0;

        // loop through until you find the matching index
        while ($current !== null) {
            if ($count === $this->turn) {
                // player found, now draw card!

                // draws card from deck
                $card = $this->deck->drawCard();

                // adds it to the CardHand
                $current->data->add($card);

                return $current;
            }
            $count++;
            $current = $current->next;
        }

        // returns null if there is no match
        return null;
    }



    /**
     * Draw a card for the player att certain index.
     * @return ?Node
     */
    public function OLDdrawCardForPlayerAtIndex(int $index): ?Node
    {

        $current = $this->head;
        $count = 0;

        // loop through until you find the matching index
        while ($current !== null) {
            if ($count === $index) {
                // player found, now draw card!

                // draws card from deck
                $card = $this->deck->drawCard();

                // adds it to the CardHand
                $current->data->add($card);

                return $current->data->getValues();
            }
            $count++;
            $current = $current->next;
        }

        // returns null if there is no match
        return null;
    }

}
