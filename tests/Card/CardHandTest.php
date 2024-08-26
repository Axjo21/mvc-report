<?php declare(strict_types=1);
namespace App\Test;

use PHPUnit\Framework\TestCase;


use App\Card\CardHand;
use App\Card\BetterCard;

/**
 * Test cases for class CardHand.
 */
final class CardHandTest extends TestCase
{
    /**
     * Test that getNumberCards method works as intended.
     */
    public function testGetNumberCards(): void
    {
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);

        $numberOfCards = $cardHand->getNumberCards();

        $this->assertEquals(0, $numberOfCards);
    }


    /**
     * Test that add method works as intended.
     */
    public function testAdd(): void
    {
        // init hand
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);

        // init card
        $newCard = new BetterCard('🂮', 'spades', 13);
        $this->assertInstanceOf("\App\Card\BetterCard", $newCard);

        // check default value is correct
        $numberOfCards = $cardHand->getNumberCards();
        $this->assertEquals(0, $numberOfCards);

        // check that value is correct after adding a card
        $cardHand->add($newCard);
        $numberOfCards = $cardHand->getNumberCards();
        $this->assertEquals(1, $numberOfCards);
    }


    /**
     * Test that getValues method works as intended.
     */
    public function testGetValues(): void
    {
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);

        $firstCard = new BetterCard('🂮', 'spades', 13);
        $this->assertInstanceOf("\App\Card\BetterCard", $firstCard);
        $secondCard = new BetterCard('🃙', 'clovers', 9);
        $this->assertInstanceOf("\App\Card\BetterCard", $secondCard);
        $thirdCard = new BetterCard('🃅', 'diamonds', 5);
        $this->assertInstanceOf("\App\Card\BetterCard", $thirdCard);

        $cardHand->add($firstCard);
        $cardHand->add($secondCard);
        $cardHand->add($thirdCard);

        $cardValues = $cardHand->getValues();

        $this->assertSame([['🂮', 'spades'], ['🃙', 'clovers'], ['🃅', 'diamonds']], $cardValues);
    }

    /**
     * Test that getPoints method works as intended.
     */
    public function testGetPoints(): void
    {
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);

        $firstCard = new BetterCard('🃑', 'clovers', 14);
        $this->assertInstanceOf("\App\Card\BetterCard", $firstCard);
        $secondCard = new BetterCard('🃙', 'clovers', 9);
        $this->assertInstanceOf("\App\Card\BetterCard", $secondCard);
        $thirdCard = new BetterCard('🃅', 'diamonds', 5);
        $this->assertInstanceOf("\App\Card\BetterCard", $thirdCard);

        $cardHand->add($firstCard);
        $cardHand->add($secondCard);
        $cardHand->add($thirdCard);

        $handPoints = $cardHand->getPoints();
        $this->assertEquals(15, $handPoints);
    }

}
