<?php declare(strict_types=1);
namespace App\Test;

use PHPUnit\Framework\TestCase;


use App\Card\DeckOfCards;
use App\Card\BetterCard;

/**
 * Test cases for class DeckOfCards.
 */
final class DeckOfCardsTest extends TestCase
{
    /**
     * Test that getNumberCards method works as intended.
     */
    public function testGetNumberOfCards(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        $numberOfCards = $deck->getNumberCards();

        $this->assertEquals(52, $numberOfCards);
    }

    /**
     * Test that getCards method works as intended.
     */
    public function testGetCards(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        $cards = $deck->getCards();

        // kollar att $cards endast innehåller BetterCard
        $this->assertContainsOnlyInstancesOf(BetterCard::class, $cards);
        // kollar att de är lika långa, i.e att DeckOfCards innehåller 52 BetterCards
        $deck = [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            51, 52
        ];
        $this->assertSameSize($deck, $cards);
    }

    /**
     * Test that getValues works as intended.
     */
    public function testGetValues(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        $cardValues = $deck->getValues();

        $expected = [
            '🂡', '🂢', '🂣', '🂤', '🂥', '🂦', '🂧', '🂨', '🂩', '🂪', '🂫', '🂭',
            '🂮',
            '🂱', '🂲', '🂳', '🂴', '🂵', '🂶', '🂷', '🂸', '🂹', '🂺', '🂻', '🂽',
            '🂾',
            '🃑', '🃒', '🃓', '🃔', '🃕', '🃖', '🃗', '🃘', '🃙', '🃚', '🃛', '🃝',
            '🃞',
            '🃁', '🃂', '🃃', '🃄', '🃅', '🃆', '🃇', '🃈', '🃉', '🃊', '🃋', '🃍',
            '🃎'
        ];

        $this->assertSame($cardValues, $expected);

    }

    /**
     * Test that getSuit works as intended.
     */
    public function testGetSuit(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        $cardSuits = $deck->getSuit();

        // fula tester när jag skriver såhär.. men det gör jobbet
        $expected = [
            'spades', 'spades', 'spades', 'spades','spades', 'spades',
            'spades', 'spades', 'spades', 'spades', 'spades', 'spades',
            'spades',
            'hearts', 'hearts', 'hearts', 'hearts','hearts', 'hearts',
            'hearts', 'hearts', 'hearts', 'hearts', 'hearts', 'hearts',
            'hearts',
            'clovers', 'clovers', 'clovers', 'clovers','clovers', 'clovers',
            'clovers', 'clovers', 'clovers', 'clovers', 'clovers', 'clovers',
            'clovers',
            'diamonds', 'diamonds', 'diamonds', 'diamonds','diamonds', 'diamonds',
            'diamonds', 'diamonds', 'diamonds', 'diamonds', 'diamonds', 'diamonds',
            'diamonds',
        ];

        $this->assertSame($cardSuits, $expected);

    }

    /**
     * Test that shuffleDeck method works as intended.
     * This test asserts that the deck still has the same amount of cards
     * and that they are not in the default order after shuffling the deck.
     */
    public function testShuffleDeck(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        // check number of cards
        $numberOfCards = $deck->getNumberCards();
        $this->assertEquals(52, $numberOfCards);

        // these should match since this is the default values
        $cardValues = $deck->getValues();
        $expected = [
            '🂡', '🂢', '🂣', '🂤', '🂥', '🂦', '🂧', '🂨', '🂩', '🂪', '🂫', '🂭',
            '🂮',
            '🂱', '🂲', '🂳', '🂴', '🂵', '🂶', '🂷', '🂸', '🂹', '🂺', '🂻', '🂽',
            '🂾',
            '🃑', '🃒', '🃓', '🃔', '🃕', '🃖', '🃗', '🃘', '🃙', '🃚', '🃛', '🃝',
            '🃞',
            '🃁', '🃂', '🃃', '🃄', '🃅', '🃆', '🃇', '🃈', '🃉', '🃊', '🃋', '🃍',
            '🃎'
        ];
        $this->assertSame($cardValues, $expected);

        // shuffle deck and retrieve values
        $deck->shuffleDeck();
        $cardValuesNew = $deck->getValues();

        // check number of cards is still the same after shuffle
        $numberOfCardsNew = $deck->getNumberCards();
        $this->assertEquals(52, $numberOfCardsNew);

        // check that the deck has been shuffled correctly.
        $this->assertNotSame($expected, $cardValuesNew);

    }

    /**
     * Test that drawCard method works as intended.
     * Checks that the drawn card is of BetterCard class and that
     * the deck contains one less card.
     */
    public function testDrawCard(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        // check number of cards
        $numberOfCards = $deck->getNumberCards();
        $this->assertEquals(52, $numberOfCards);


        // draw card and assert that the card is of BetterCard class
        $drawnCard = $deck->drawCard();
        $this->assertInstanceOf("\App\Card\BetterCard", $drawnCard);

        // check number of cards is one less after drawing a card
        $numberOfCardsNew = $deck->getNumberCards();
        $this->assertEquals(51, $numberOfCardsNew);

    }

    /**
     * Test that apiDraw method works as intended.
     * Checks that the drawn card is of BetterCard class and that
     * the deck contains one less card.
     */
    public function testApiDraw(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        // check number of cards
        $numberOfCards = $deck->getNumberCards();
        $this->assertEquals(52, $numberOfCards);


        // draw card and assert that the card is of BetterCard class
        $drawnCard = $deck->apiDraw();
        $this->assertInstanceOf("\App\Card\BetterCard", $drawnCard);

        // check number of cards is one less after drawing a card
        $numberOfCardsNew = $deck->getNumberCards();
        $this->assertEquals(51, $numberOfCardsNew);
    }

    /**
     * Test that remove method works as intended.
     */
    public function testRemove(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        // check number of cards
        $numberOfCards = $deck->getNumberCards();
        $this->assertEquals(52, $numberOfCards);

        $cardOfInterest = new BetterCard('🃖', 'clovers', 6);
        $deck->remove($cardOfInterest);

        // check number of cards is one less after removing
        $numberOfCardsNew = $deck->getNumberCards();
        $this->assertEquals(51, $numberOfCardsNew);

        // check that the deck does not contain the removed card
        $cards = $deck->getCards();
        $this->assertNotContains($cardOfInterest, $cards);
    }


}
