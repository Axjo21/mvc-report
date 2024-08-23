<?php declare(strict_types=1);
namespace App\Test;

use PHPUnit\Framework\TestCase;

use App\Card\BetterCard;


final class TestBetterCard extends TestCase
{
    public function testSetValue(): void
    {
        $card = new BetterCard('🂮', 'spades', 13);

        $card->setValue("something");
        $card_value = $card->getValue();

        $this->assertSame('something', $card_value);
    }

    public function testSetPoints(): void
    {
        $card = new BetterCard('🂮', 'spades', 13);

        $card->setPoints(2);
        $card_points = $card->getPoints();

        $this->assertSame(2, $card_points);
    }
}
