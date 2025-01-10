<?php

namespace App\Controller;

use App\Repository\BookReadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Book;
use App\Entity\BookRead;
use App\Entity\Category;
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
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {

        $user       = $this->getUser();
        $userId     = $user instanceof User ? $user->getId() : null;
        $booksRead  = $userId ? $this->readBookRepository->findByUserId($userId, false) : null;
        $allBooks = $entityManager->getRepository(Book::class)->findAll();

        $ratedBooks = $entityManager->getRepository(BookRead::class)->findBy(['user' => $user]);
        $ratedBookIds = array_map(function (BookRead $bookRead) {
            return $bookRead->getBook()->getId();
        }, $ratedBooks);

        $books = array_filter($allBooks, function (Book $book) use ($ratedBookIds) {
            return !in_array($book->getId(), $ratedBookIds);
        });

        // $bookReadId = $request->query->get('bookReadId');
        // $bookRead = null;
        // if ($bookReadId) {
        //     $bookRead = $entityManager->getRepository(BookRead::class)->find($bookReadId);
        //     if ($bookRead) {
        //         $request->getSession()->set('bookReadId', $bookReadId);
        //     } else {
        //         $this->addFlash('error', 'BookRead not found.');
        //     }
        // } else {
        //     $bookReadId = 1;
        // }

        $categories = $entityManager->getRepository(Category::class)->findAll();

        $categoryData = [];
        foreach ($categories as $category) {
            $booksReadCount = $entityManager->getRepository(BookRead::class)->createQueryBuilder('br')
                ->select('count(br.id)')
                ->join('br.book', 'b')
                ->where('br.user = :user')
                ->andWhere('b.category = :category')
                ->andWhere('br.isFinished = false')
                ->setParameter('user', $user)
                ->setParameter('category', $category)
                ->getQuery()
                ->getSingleScalarResult();

            $booksFinishedCount = $entityManager->getRepository(BookRead::class)->createQueryBuilder('br')
                ->select('count(br.id)')
                ->join('br.book', 'b')
                ->where('br.user = :user')
                ->andWhere('b.category = :category')
                ->andWhere('br.isFinished = true')
                ->setParameter('user', $user)
                ->setParameter('category', $category)
                ->getQuery()
                ->getSingleScalarResult();

            $categoryData[] = [
                'name' => $category->getName(),
                'booksReadCount' => $booksReadCount,
                'booksFinishedCount' => $booksFinishedCount,
            ];
        }
        if ($user){
            if ($request->query->get('search')) {
                $booksReading = $entityManager->getRepository(BookRead::class)->searchBooksByName($request->query->get('search'));
            }}
        $booksReading = $entityManager->getRepository(BookRead::class)->findBy([
            'user' => $user,
            'isFinished' => false,
        ]);

        if($user){
            if ($request->query->get('searchfinished')){
                $booksFinished = $entityManager->getRepository(BookRead::class)->searchFinishedBooksByName($request->query->get('searchfinished'));
            }
        $booksFinished = $entityManager->getRepository(BookRead::class)->findBy([
            'user' => $user,
            'isFinished' => true,
        ]);
        }

        // Render the 'hello.html.twig' template
        return $this->render('pages/home.html.twig', [
            'books' => $allBooks,
            'booksRead' => $booksRead,
            'name' => 'Accueil', // Pass data to the view
            'user' => $user,
            'booksToRate' => $books,
            'booksReading' => $booksReading,
            // 'bookRead' => $bookRead,
            'booksFinished' => $booksFinished, 
            'categoryData' => $categoryData,   
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

    // #[Route('/book/read/{id}', name: 'book_read_data', methods: ['GET'])]
    // public function getBookReadData(int $id, EntityManagerInterface $entityManager): JsonResponse
    // {
    //     $bookRead = $entityManager->getRepository(BookRead::class)->find($id);

    //     if (!$bookRead) {
    //         return new JsonResponse(['error' => 'BookRead not found'], Response::HTTP_NOT_FOUND);
    //     }

    //     $data = [
    //         'id' => $bookRead->getId(),
    //         'book' => [
    //             'title' => $bookRead->getBook()->getName(),
    //         ],
    //         'description' => $bookRead->getDescription(),
    //         'rating' => $bookRead->getRating(),
    //         'isFinished' => $bookRead->getIsFinished(),
    //     ];

    //     return new JsonResponse($data);
    // }

    #[Route('/book/edit', name: 'book_edit', methods: ['POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $bookReadId = $request->request->get('bookReadId');
        $bookRead = $entityManager->getRepository(BookRead::class)->find($bookReadId);

        if (!$bookRead || $bookRead->getUser() !== $user) {
            $this->addFlash('error', 'You are not authorized to edit this rating.');
            return $this->redirectToRoute('app.home');
        }

        if ($request->isMethod('POST')) {
            $description = $request->request->get('comment');
            $rating = $request->request->get('rating');
            $isFinished = $request->request->get('isFinished');

            $bookRead->setDescription($description);
            $bookRead->setRating($rating);
            $bookRead->setFinished($isFinished);
            if ($isFinished == 'true') {
                $bookRead->setRead(false);
            } else {
                $bookRead->setRead(true);
            }
            $bookRead->setUpdatedAt(new \DateTime());

            $entityManager->flush();

            $this->addFlash('success', 'Book rating updated successfully.');

            return $this->redirectToRoute('app.home');
        }

        return $this->render('modals/edit.html.twig', [
            'bookRead' => $bookRead,
        ]);
    }
}
