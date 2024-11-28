<?php declare(strict_types=1);
namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\Card\BankHand;
use App\Card\DeckOfCards;

/**
 * Test cases for class BankHand.
 */
final class BankHandTest extends TestCase
{
    /**
     * Test that drawCards method works as intended.
     */
    public function testDrawCards(): void
    {
        $cardDeck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $cardDeck);

        $bankHand = new BankHand($cardDeck);
        $this->assertInstanceOf("\App\Card\BankHand", $bankHand);

        $bankHand->drawCards();

        // bankHand should now contain at least 2 cards
        $numberOfCards = $bankHand->getNumberCards();
        $this->assertGreaterThan(1, $numberOfCards);

        // bankHand should have more than 0 points
        $bankHandPoints = $bankHand->getPoints();
        $this->assertGreaterThan(0, $bankHandPoints);
    }
}
