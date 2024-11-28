<?php declare(strict_types=1);
namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\Card\Node;
use App\Card\CardHand;

/**
 * Test cases for Node class.
 */
final class NodeTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * default properties.
     */
    public function testGetNodeProperties(): void
    {
        $hand = new CardHand();
        $node = new Node($hand);
        $this->assertInstanceOf("\App\Card\CardHand", $hand);
        $this->assertInstanceOf("\App\Card\Node", $node);

        //data
        $nodeData = $node->getData();
        $this->assertSame($hand, $nodeData);

        //next
        $nodeNext = $node->getNext();
        $this->assertSame(null, $nodeNext);

        // betPool
        $nodeBetPool = $node->getBetPool();
        $this->assertSame(0, $nodeBetPool);

        // bank boolean
        $nodeBank = $node->bank;
        $this->assertSame(false, $nodeBank);
    }

    /**
     * Construct object and verify that the objects "set" methods works.
     */
    public function testSetNodeProperties(): void
    {
        $hand = new CardHand();
        $node = new Node($hand);
        $this->assertInstanceOf("\App\Card\CardHand", $hand);
        $this->assertInstanceOf("\App\Card\Node", $node);

        //data
        $newHand = new CardHand();
        $node->setData($newHand);
        $nodeData = $node->getData();
        $this->assertSame($newHand, $nodeData);

        //next
        $newNode = new Node($newHand);
        $node->setNext($newNode);
        $nodeNext = $node->getNext();
        $this->assertSame($newNode, $nodeNext);

        // betPool
        $node->placeBet(155);
        $nodeBetPool = $node->getBetPool();
        $this->assertSame(155, $nodeBetPool);

        // bank boolean
        $nodeBank = $node->bank;
        $this->assertSame(false, $nodeBank);
    }
}
