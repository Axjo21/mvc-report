<?php declare(strict_types=1);
namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\Card\BetterCard;

/**
 * Test cases for class BetterCard.
 */
final class BetterCardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testSetValue(): void
    {
        $card = new BetterCard('🂮', 'spades', 13);
        $this->assertInstanceOf("\App\Card\BetterCard", $card);

        $card->setValue("something");
        $cardValue = $card->getValue();

        $this->assertSame('something', $cardValue);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testSetPoints(): void
    {
        $card = new BetterCard('🂮', 'spades', 13);
        $this->assertInstanceOf("\App\Card\BetterCard", $card);

        $card->setPoints(2);
        $cardPoints = $card->getPoints();

        $this->assertSame(2, $cardPoints);
    }
}
