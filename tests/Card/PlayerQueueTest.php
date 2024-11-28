<?php declare(strict_types=1);
namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\Card\Node;
use App\Card\PlayerQueue;
use App\Card\DeckOfCards;

/**
 * Test cases for Node class.
 */
final class PlayerQueueTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * default properties.
     */
    public function testPlayerQueueProperties(): void
    {
        $playerQueue = new PlayerQueue();
        $this->assertInstanceOf("\App\Card\PlayerQueue", $playerQueue);

        //head
        $head = $playerQueue->head;
        $this->assertSame(null, $head);
        //deck
        $deck = $playerQueue->deck;
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
        //numberOfPlayers
        $numberOfPlayers = $playerQueue->numberOfPlayers;
        $this->assertSame(0, $numberOfPlayers);
        //turn
        $turn = $playerQueue->turn;
        $this->assertSame(0, $turn);
        //winner
        $winner = $playerQueue->winner;
        $this->assertSame(null, $winner);
    }

    /**
     * Verify that playerQueue->advanceQueue() works.
     */
    public function testPlayerQueueAdvanceQueue(): void
    {
        $playerQueue = new PlayerQueue();
        $this->assertInstanceOf("\App\Card\PlayerQueue", $playerQueue);

        // turn default
        $turn = $playerQueue->turn;
        $this->assertSame(0, $turn);

        // advance turn 3 times
        $playerQueue->advanceQueue();
        $playerQueue->advanceQueue();
        $playerQueue->advanceQueue();
        $turn = $playerQueue->turn;
        $this->assertSame(3, $turn);
    }

    /**
     * Verify that playerQueue->addPlayer() works.
     */
    public function testPlayerQueueAddPlayer(): void
    {
        $playerQueue = new PlayerQueue();
        $this->assertInstanceOf("\App\Card\PlayerQueue", $playerQueue);

        //head
        $head = $playerQueue->head;
        $this->assertSame(null, $head);

        $playerQueue->addPlayer("Axel");
        $playerQueue->addPlayer("John Doe");
        $playerQueue->addPlayer("Jane Doe");

        $headName = $playerQueue->head->data->name;
        $this->assertSame("Axel", $headName);

        //numberOfPlayers
        $numberOfPlayers = $playerQueue->numberOfPlayers;
        $this->assertSame(3, $numberOfPlayers);
    }

    /**
     * Verify that playerQueue->addBank() works.
     */
    public function testPlayerQueueAddBank(): void
    {
        $playerQueue = new PlayerQueue();

        $playerQueue->addPlayer("Axel");
        $playerQueue->addPlayer("John Doe");
        $playerQueue->addPlayer("Jane Doe");
        $playerQueue->addBank("Bank Test");

        //numberOfPlayers
        $numberOfPlayers = $playerQueue->numberOfPlayers;
        $this->assertSame(4, $numberOfPlayers);

        // advance turn 4 times (so it's the banks turn)
        $playerQueue->advanceQueue();
        $playerQueue->advanceQueue();
        $playerQueue->advanceQueue();
        $playerQueue->advanceQueue();
        $turn = $playerQueue->turn;
        $this->assertSame(4, $turn);
        //märker att turn är 0-indexed och numberOfPlayers är 1-indexed...

        $banksTurn = $playerQueue->banksTurn();
        $this->assertSame(true, $banksTurn);
    }

    /**
     * Verify that playerQueue->addBank() works.
     */
    public function testPlayerQueueGetPlacedBets(): void
    {
        $playerQueue = new PlayerQueue();

        $playerQueue->addPlayer("Axel");
        $playerQueue->addPlayer("John Doe");
        $playerQueue->addBank("Bank Test");

        $playerQueue->placeBet(50, 1);
        $playerQueue->placeBet(50, 2);

        $placedBets = $playerQueue->getPlacedBets();
        $this->assertSame(100, $placedBets);
    }
}
