<?php declare(strict_types=1);
namespace App\Test;

use PHPUnit\Framework\TestCase;


use App\Card\Card;

final class TestCard extends TestCase
{
    public function testGetValue(): void
    {
        $card = new Card('🂮', 'spades', 13);

        $card_value = $card->getValue();

        $this->assertSame('🂮', $card_value);
    }

    public function testGetDetails(): void
    {
        $card = new Card('🂮', 'spades', 13);

        $card_details = $card->getDetails();

        $this->assertSame(['🂮', 'spades'], $card_details);
    }
}
