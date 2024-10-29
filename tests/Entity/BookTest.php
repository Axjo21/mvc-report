<?php

namespace App\Entity\Book;

use PHPUnit\Framework\TestCase;
use App\Entity\Book;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Test cases for class Book.
 */
class BookTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testBookCreate(): void
    {
        $book = new Book();
        $this->assertInstanceOf("\App\Entity\Book", $book);

        // id != null
        $id = $book->getId();
        $this->assertEquals($id, null);

        // title === null
        $title = $book->getTitle();
        $this->assertEquals($title, null);
    }

    /**
     * Construct object and verify that the objects setImage method
     * throws exception
     */
    public function testBookSetImageException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('File upload error');

        $book = new Book();
        $image =  '../public/img/book-cover-placeholder.png';
        $book->setImage($image);

    }

    /**
     * Construct object and verify that the objects setImage method
     * throws exception with an error when passing svg image
     */
    public function testBookSetImageExceptionSvgError(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unsupported image type: image/svg');

        // image mock
        $mockFile = $this->createMock(UploadedFile::class);

        // configure mock
        $mockFile->method('isValid')->willReturn(true);
        $mockFile->method('getMimeType')->willReturn('image/svg');
        $mockFile->method('getPathname')->willReturn('/some/path/mock.jpg');

        $book = new Book();
        $book->setImage($mockFile);

    }

}