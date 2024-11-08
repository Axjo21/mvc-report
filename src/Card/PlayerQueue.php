<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\DeckOfCards;

/**
 * En helper klass för BlackJack.
 */
class PlayerQueue
{
    public array $players;
    public int $numberOfPlayers;
    public int $currentTurn;
    public DeckOfCards $deck;

    /**
     * Construct the values
     */
    public function __construct(DeckOfCards $deck)
    {
        $this->deck = $deck;
        $this->players = [];
        $this->numberOfPlayers = 0;
        $this->currentTurn = $this->players[0];
    }


    /**
     * Add player
     * @return void
     */
    public function addPlayer($name): void
    {
        $hand = new CardHand($name);
        $firstCard = $this->deck->drawCard();
        $secondCard = $this->deck->drawCard();
        
        $hand->add($firstCard);
        $hand->add($secondCard);
        array_push($this->players, $hand);
        $this->numberOfPlayers += 1;
    }

    /**
     * Promote the queue; next players turn
     * @return void
     */
    public function promoteQueue(): void
    {
        $this
        return;
    }


    /**
     * Get current players turn
     * @return int
     */
    public function getCurrentTurn(): int
    {
        return $this->currentTurn;
    }

    /**
     * Get players
     * @return array
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * Get player details
     * @return array
     */
    public function getPlayerCardDetails(): array
    {
        $data = [];
        forEach($this->players as $player) {
            $playerData = [
                "name" => $player->name,
                "cards" => $player->getValues(),
                "points" => $player->getPoints(),
                "playersTurn" => $player === $this->players[0] && $player->getPoints() < 21
            ];          // bool for if it's players turn
            array_push($data, $playerData);
        };

        return $data;
    }


    /**
     * Get player
     * @return CardHand
     */
    public function getPlayerHand(): CardHand
    {
        return $this->players[0];
    }

    /**
     * Get player name.
     * @return string
     */
    public function getPlayerName(): string
    {
        return $this->players[0]->player;
    }

    /**
     * Remove player from queue. (when they are done drawing cards)
     * @return void
     */
    public function removePlayer(): void
    {
        array_shift($this->players);
    }

}
