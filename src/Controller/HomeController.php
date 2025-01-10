<?php

namespace App\Controller;

use App\Repository\BookReadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Book;
use App\Entity\BookRead;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    private BookReadRepository $readBookRepository;

    // Inject the repository via the constructor
    public function __construct(BookReadRepository $readBookRepository)
    {
        $this->readBookRepository = $readBookRepository;
    }

    #[Route('/', name: 'app.home')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $user       = $this->getUser();
        $userId     = $user instanceof User ? $user->getId() : null;
        $booksRead  = $userId ? $this->readBookRepository->findByUserId($userId, false) : null;
        $allBooks = $entityManager->getRepository(Book::class)->findAll();

        $ratedBooks = $entityManager->getRepository(BookRead::class)->findBy(['user' => $user]);
        $ratedBookIds = array_map(function (BookRead $bookRead) {
            return $bookRead->getBook()->getId();
        }, $ratedBooks);

        // Filter out the rated books from all books
        $books = array_filter($allBooks, function (Book $book) use ($ratedBookIds) {
            return !in_array($book->getId(), $ratedBookIds);
        });

        // Render the 'hello.html.twig' template
        return $this->render('pages/home.html.twig', [
            'books' => $allBooks,
            'booksRead' => $booksRead,
            'name' => 'Accueil', // Pass data to the view
            'user' => $user,
            'booksToRate' => $books
        ]);
    }

    #[Route('/book/read', name: 'book_read', methods: ['POST'])]
    public function read(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }        

            

        $bookId = $request->request->get('book');
        $description = $request->request->get('comment');
        $rating = $request->request->get('rating');
        $isFinished = $request->request->get('isFinished');

        $book = $entityManager->getRepository(Book::class)->find($bookId);
        if ($book) {
                    // Check if the user has already rated this book
                    $existingRating = $entityManager->getRepository(BookRead::class)->findOneBy([
                        'user' => $user,
                        'book' => $book,
                    ]);
                }
            if ($existingRating) {
                // Add a flash message to indicate that the user has already rated this book
                $this->addFlash('error', 'You have already rated this book.');

                return $this->redirectToRoute('book');
            }
        if ($book) {
            $bookRead = new BookRead();
            $bookRead->setUser($user);
            $bookRead->setBook($book);
            $bookRead->setDescription($description);
            $bookRead->setRating($rating);
            $bookRead->setFinished($isFinished);
            if ($isFinished == 'true') {
                $bookRead->setRead(false);
            } else {
                $bookRead->setRead(true);
            }
            $bookRead->setCreatedAt(new \DateTime());
            $bookRead->setUpdatedAt(new \DateTime());

            $entityManager->persist($bookRead);
            $entityManager->flush();

            return $this->redirectToRoute('app.home');
        }

        return $this->redirectToRoute('app.home');
    }
}
