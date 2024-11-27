<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\Node;

/**
 * En helper klass för BlackJack.
 */
class PlayerQueue
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
     * Additionally, the method does a check to see if it's the banks turn
     * if so, the executeBanksTurn gets called which in turn calls the
     * last Nodes (of BankHand class) "executeTurn" method which performs the banks
     * logic for drawing cards. 
     * @return void
     */
    public function advanceQueue(): void
    {
        $this->turn += 1;
        // $this->banksTurn() && $this->executeBanksTurn();
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
        $this->turn === $counter && $this->executeBanksTurn();

        return $this->turn === $counter;
    }

    /**
     * Finds the bank and executes the mathod for showing the hidden card. 
     * @return void
     */
    public function showBanksHiddenCard(): void
    {
        $current = $this->head;
        $prev = $this->head;
        while ($current !== null) {
            $prev = $current;
            $current = $current->next;
        }
        if ($prev->data instanceof BankHand) {
            $prev->data->showHiddenCard();
        }
    }

    /**
     * Performs a check and returns a boolean for wether or not
     * each player has already had their turn.
     * @return void
     */
    public function executeBanksTurn(): void
    {
        $current = $this->head;
        $prev = $this->head;
        $playersPoints = [];
        $counter = 0;
        while ($current !== null) {
            array_push($playersPoints, $current->data->getPoints());
            $prev = $current;
            $current = $current->next;
            $counter++;
        }
        // if it is the banks turn
        if ($this->turn === $counter && $prev->data instanceof BankHand) {
            $prev->data->executeTurn($playersPoints);
        }
    }


    /**
     * Add player node to the linked list.
     * Since it is possible to get 21 from 2 cards, a check needs to be made aswell. 
     * @return ?Node
     */
    public function addPlayer(string $name, ?bool $bank=false): ?Node
    {
        $winnerNode = null;
        if ($bank) {
            $hand = new BankHand($this->deck, $name);

            // "riktigt kort" som sedan återskapas i BankHand->executeTurn();
            $firstCard = $this->deck->drawCard();
            $hand->setHiddenCard($firstCard);

            // "låtsas kort" som representerar nervänt
            $temporaryCard = new BetterCard("🂠", "spades", 0);
            $hand->add($temporaryCard);

            // dra vanligt kort
            $secondCard = $this->deck->drawCard();
            $hand->add($secondCard);

            $node = new Node($hand);
            $node->bank = true;
            // 21 check
            $bankPoints = $firstCard->getPoints() + $firstCard->getPoints();
            if($bankPoints === 21) {
                $winnerNode =  $node;
            }
        } else {
            $hand = new CardHand($name);
            $firstCard = $this->deck->drawCard();
            $secondCard = $this->deck->drawCard();
            
            $hand->add($firstCard);
            $hand->add($secondCard);
            $node = new Node($hand);
            // 21 check
            if($hand->getPoints() === 21) {
                $winnerNode =  $node;
            }
        }

        // create node with hand as data
        if ($this->head === null) {
            $this->head = $node;
            return $winnerNode;
        }

        // koppla nod till listan
        $current = $this->head;
        while ($current->next !== null) {
            $current = $current->next;
        }
        $current->next = $node;


        $this->numberOfPlayers += 1;
        return $winnerNode;
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

        while ($current !== null) {
            if ($count === $index) {
                return $current->data;
            }
            $count++;
            $current = $current->next;
        }
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
                "playersTurn" => $this->turn === $counter, // players turn bool
                "bank" => $current->bank
            ];
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
        return null;
    }


    /**
     * Draw a card for the player att certain index.
     * House rules: 
     *  - If more than one player has 21, they win. 
     * @return array
     */
    public function calculateWinner(): array
    {
        // $result = $this->getScores();
        
        $current = $this->head;
        $nodeWithHighestPoint = $this->head;
        $winners = [];
        while ($current !== null) {
            $point = $current->data->getPoints();
            if($point === 21) {
                array_push($winners, $current);
            }
            if($point <= 21 && $point >= $nodeWithHighestPoint->data->getPoints()) {
                $nodeWithHighestPoint = $current;
            }
            // ifall ingen har vunnit, och current är banken
            if($current->next === null && count($winners) === 0){
                array_push($winners, $current);
            }
            $current = $current->next;
        }
        if($nodeWithHighestPoint->data->getPoints() <= 21 && !in_array($nodeWithHighestPoint, $winners)) {
            array_push($winners, $nodeWithHighestPoint);
        }
        return $winners;
    }


    /**
     * Place a bet.
     * @return void
     */
    public function placeBet(int $bet, int $position): void
    {
        $current = $this->head;
        $count = 1;
        while ($current !== null) {
            if ($count === $position) {
                $current->placeBet($bet);
            }
            $count++;
            $current = $current->next;
        }
        return;
    }

    /**
     * Get total bets.
     * @return int
     */
    public function getPlacedBets(): int
    {
        $current = $this->head;
        $betPool = 0;
        while ($current !== null) {
            $currentBet = $current->getBetPool();
            $betPool += $currentBet;
            $current = $current->next;
        }
        return $betPool;
    }
}
