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
    #[Route('/library', name: 'library', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('book/home.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }


    # CREATE (form)
    #[Route('/library/create_new', name: 'library_create_new', methods: ['GET'])]
    public function createNewBook(): Response
    {
        return $this->render('book/create.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }


    # CREATE (actually create)
    #[Route('/library/create', name: 'library_create', methods: ['POST'])]
    public function createBook(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {

        $entityManager = $doctrine->getManager();
        $book = new Book();

        $title = $request->request->get('book_title');
        $author = $request->request->get('book_author');
        $isbn = $request->request->get('book_isbn');
        $imageFile = $request->files->get('book_image');

        // check if image is set and gather it's mime-type
        if ($imageFile) {
            $book->setImage($imageFile);
        }

        $book->setDetails($title, $author, $isbn);


        # persist = eventually save, flush = actually save
        $entityManager->persist($book);
        $entityManager->flush();

        $this->addFlash('success', 'Your changes have been saved successfully.');

        return $this->redirectToRoute('library_view_all');
    }


    # VIEW ALL
    #[Route('/library/view', name: 'library_view_all', methods: ['GET'])]
    public function viewAllBook(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();
        $images = [];
        // save images for each book
        foreach ($books as $book) {
            $result = $book->getImage();
            if($result) {
                $imageData = $result['imageData'];
                $mimeType = $result['mimeType'];
                // save data and mime for each image to the images array
                $images[$book->getId()] = ['data' => $imageData, 'mime' => $mimeType];
            }
        };

        $data = [
            'books' => $books,
            'images' => $images
        ];
        //var_dump($images);

        return $this->render('book/view.html.twig', $data);
    }

    # VIEW SINGLE
    #[Route('/library/view/{id}', name: 'library_view_by_id', methods: ['GET', 'POST'])]
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

        $result = $book->getImage();

        if($result) {
            $imageData = $result['imageData'];
            $mimeType = $result['mimeType'];
            $data = [
                'book' => $book,
                'image' => $imageData,
                'mime_type' => $mimeType
            ];
            return $this->render('book/single.html.twig', $data);
        }
        $data = [
            'book' => $book,
            'image' => null
        ];
        return $this->render('book/single.html.twig', $data);   
    }


    # UPDATE
    #[Route('/library/update_book/{id}', name: 'library_update_book', methods: ['GET', 'POST'])]
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
    #[Route('/library/update/{id}', name: 'library_update', methods: ['POST'])]
    public function updateBook(
        ManagerRegistry $doctrine,
        int $id,
        Request $request
    ): Response {
        try {
            $entityManager = $doctrine->getManager();
            $book = $entityManager->getRepository(Book::class)->find($id);
    
            if (!$book) {
                throw $this->createNotFoundException(
                    'No book found for id '.$id
                );
            }
    
            $imageFile = $request->files->get('book_image_update');
            $book->setImage($imageFile);

            $title = $request->request->get('title');
            $author = $request->request->get('author');
            $isbn = $request->request->get('isbn');
            $book->setDetails($title, $author, $isbn);

            $entityManager->flush();
    
            $this->addFlash('success', 'Your changes have been saved successfully.');
    
            return $this->redirectToRoute('library_view_by_id', ['id' => $id]);
        } catch (\Exception $e) {
            $this->addFlash('error', 'An error occurred: ' . $e->getMessage());
            return $this->redirectToRoute('library_view_by_id', ['id' => $id]);
        }
    }


    # DELETE
    #[Route('/library/delete_book/{id}', name: 'library_delete_book_by_id', methods: ['POST'])]
    public function deleteSingleBookById(
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
        $data = [
            'book' => $book
        ];

        return $this->render('book/delete.html.twig', $data);
    }


    # DELETE (actually delete)
    #[Route('/library/delete/{id}', name: 'library_delete_by_id', methods: ['POST'])]
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

        $this->addFlash('success', 'Your changes have been saved successfully.');

        return $this->redirectToRoute('library_view_all');
    }













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
