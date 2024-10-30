<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;

class ApiControllerBookJson extends AbstractController
{
    # SHOW ALL (JSON respons)
    #[Route('/api/library/books', name: 'api_library', methods: ['GET'])]
    public function showAllBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();
        $response = $this->json($books);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    // FÖR ISBN
    # SHOW SINGLE (JSON respons)
    #[Route('/api/library/book/{isbn}', name: 'api_library_isbn', methods: ['GET'])]
    public function showBookByIsbn(
        BookRepository $bookRepository,
        string $isbn
    ): Response {

        $book = $bookRepository->findByIsbn($isbn);

        if (!$book) {
            $data = [
                'book' => "not found"
            ];
            return $this->json($data);
        }

        return $this->json($book);
    }

    // FÖR ID
    #[Route('/api/library/show/{id}', name: 'api_library_id', methods: ['GET'])]
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        return $this->json($book);
    }
}
