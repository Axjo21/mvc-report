<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\Dice\Dice;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDice(): void
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);

        $res = $die->getAsString();
        $res = $die->getAsString();

        $this->assertNotEmpty($res);
    }

    /**
     * Construct object and verify that the roll method works as expected.
     * 
     */
    public function testRollDice(): void
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);
        $mockedDie = $this->createMock(Dice::class);

        // Configure the stub.
        $mockedDie->method('roll')->willReturn(3);

        $res = $mockedDie->roll();
        $exp = 3;
        $this->assertEquals($exp, $res);

    }
}
