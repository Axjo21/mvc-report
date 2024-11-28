<?php declare(strict_types=1);
namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\Controller\BookController;

/**
 * Test cases for class Card.
 */
final class BookControllerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testIsInstance(): void
    {
        $bookController = new BookController;
        $this->assertInstanceOf("\App\Controller\BookController", $bookController);
    }
}
