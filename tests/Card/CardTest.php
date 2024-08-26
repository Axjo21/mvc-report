<?php declare(strict_types=1);
namespace App\Test;

use PHPUnit\Framework\TestCase;


use App\Card\Card;

/**
 * Test cases for class Card.
 */
final class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testGetValue(): void
    {
        $card = new Card('🂮', 'spades', 13);
        $this->assertInstanceOf("\App\Card\Card", $card);

        $cardValue = $card->getValue();

        // assertSame:
        //  "Reports an error identified by $message
        // if the two variables $expected and $actual do not have the same type and value." - phpunit
        $this->assertSame('🂮', $cardValue);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testGetDetails(): void
    {
        $card = new Card('🂮', 'spades', 13);
        $this->assertInstanceOf("\App\Card\Card", $card);

        $cardDetails = $card->getDetails();

        $this->assertSame(['🂮', 'spades'], $cardDetails);
    }
}
