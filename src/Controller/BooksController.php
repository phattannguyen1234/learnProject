<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Entity\Book as EntityBook;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;


class BooksController extends AbstractController
{
    #[Route('/books', name: 'book_list')]
    public function index(BookRepository $bookRepository): Response
    {
        // $abc = $bookRepository->findAll();
        $abc = $bookRepository->findAllWithCategory(); // <- change this line

        return $this->render('books/index.html.twig', [
            'book' => $abc,
        ]);
    }

    
    #[Route('/books/add', name: 'add_book')]
    public function addBook(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $newBook = new Book();

        $form = $this->createForm(BookType::class, $newBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($photo = $form['photo'] -> getData()) {
                $fileName = uniqid().'.'.$photo -> guessExtension();
                $photo -> move($this -> getParameter('photo_dir'), $fileName); 
            }
            $newBook -> setImageFileName($fileName);
            

            $entityManager = $doctrine->getManager();
            $entityManager->persist($newBook);
            $entityManager->flush();

            return $this->redirectToRoute('book_list');
        }

        return $this->render('books/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/books/{id}', name: 'view_book')]
    public function viewBook($id, BookRepository $bookRepository): Response
    {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        return $this->render('books/view.html.twig', [
            'book' => $book,
        ]);
    }


    #[Route('/books/{id}/delete', name: 'delete_book')]
    public function deleteBook($id, BookRepository $bookRepository, PersistenceManagerRegistry $doctrine): Response
    {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_list');
    }

    #[Route('/books/{id}/edit', name: 'edit_book')]
    public function editBook($id, BookRepository $bookRepository, Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('book_list');
        }

        return $this->render('books/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    
    #[Route('/search/books', name: 'search_books')]
    public function searchBooks(Request $request, BookRepository $bookRepository): Response
    {
        $price = $request->query->get('price', 0);

        $books = $bookRepository->findBooksWithPriceGreaterThan($price);

        return $this->render('books/index.html.twig', [
            'book' => $books,
        ]);
    }


}
