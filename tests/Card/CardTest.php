<?php declare(strict_types=1);
namespace App\Test;

use PHPUnit\Framework\TestCase;


use App\Card\Card;

/**
 * Test cases for class Card.
 */
final class TestCard extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testGetValue(): void
    {
        $card = new Card('🂮', 'spades', 13);
        $this->assertInstanceOf("\App\Card\Card", $card);

        $card_value = $card->getValue();

        $this->assertSame('🂮', $card_value);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testGetDetails(): void
    {
        $card = new Card('🂮', 'spades', 13);
        $this->assertInstanceOf("\App\Card\Card", $card);

        $card_details = $card->getDetails();

        $this->assertSame(['🂮', 'spades'], $card_details);
    }
}
