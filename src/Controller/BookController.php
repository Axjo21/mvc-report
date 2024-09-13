<?php

namespace App\Controller;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    # HOME
    #[Route('/library', name: 'library')]
    public function index(): Response
    {
        return $this->render('book/home.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }


    # CREATE (form)
    #[Route('/library/create_new', name: 'library_create_new')]
    public function createNewBook(): Response
    {
        return $this->render('book/create.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }


    # CREATE (actually create)
    #[Route('/library/create', name: 'library_create')]
    public function createBook(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {

        $entityManager = $doctrine->getManager();
        $book = new Book();

        #$book = $entityManager->getRepository(Book::class)->findOneBy([], ['id' => 'DESC']);

        $title = $request->request->get('book_title');
        $author = $request->request->get('book_author');
        $isbn = $request->request->get('book_isbn');

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setISBN($isbn);

        # persist = eventually save, flush = actually save
        $entityManager->persist($book);
        $entityManager->flush();

        return new Response('Saved new book with id '.$book->getId());
    }


    # VIEW ALL
    #[Route('/library/view', name: 'library_view_all')]
    public function viewAllBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }

    # VIEW SINGLE
    #[Route('/library/view/{id}', name: 'library_view_by_id')]
    public function viewBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);
        
        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $data = [
            'book' => $book
        ];

        return $this->render('book/single.html.twig', $data);
    }


    # UPDATE
    #[Route('/library/update_book/{id}', name: 'library_update_book')]
    public function updateSingleBook(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $data = [
            'book' => $book
        ];


        return $this->render('book/update.html.twig', $data);
    }

    # UPDATE (actually update)
    #[Route('/library/update/{id}', name: 'library_update')]
    public function updateBook(
        ManagerRegistry $doctrine,
        int $id,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }
        $title = $request->request->get('title');
        $author = $request->request->get('author');
        $isbn = $request->request->get('isbn');

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setIsbn($isbn);

        $entityManager->flush();

        return $this->redirectToRoute('library_view_by_id', ['id' => $id]);
    }


    # DELETE
    #[Route('/library/delete/{id}', name: 'library_delete_by_id')]
    public function deleteBookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('library_show_all');
    }













    # SHOW ALL (JSON respons)
    #[Route('/api/library/show', name: 'api_library')]
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


    # SHOW SINGLE (JSON respons)
    # gör om så att man hittar genom ISBN istället för id
    #[Route('/api/library/show/{id}', name: 'api_library_isbn')]
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        return $this->json($book);
    }


    # EJ ANVÄND
    #[Route('/library/view/{value}', name: 'library_view_minimum_value')]
    public function viewBookWithMinimumValue(
        BookRepository $bookRepository,
        int $value
    ): Response {
        $books = $bookRepository->findByMinimumValue($value);

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }


    # EJ ANVÄND
    #[Route('/library/show/min/{value}', name: 'library_by_min_value')]
    public function showBookByMinimumValue(
        BookRepository $bookRepository,
        int $value
    ): Response {
        $products = $bookRepository->findByMinimumValue2($value);

        return $this->json($products);
    }

}
