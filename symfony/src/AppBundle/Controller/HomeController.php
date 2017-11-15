<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\EntityManagerInterface;

use JMS\Serializer\SerializationContext;
// use JMS\Serializer\DeserializationContext;

use AppBundle\Entity\Book;
use AppBundle\Entity\Collection;
use AppBundle\Entity\Author;
use AppBundle\Entity\Category;
// Give a user for React test
use AppBundle\Entity\User;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage", options={"expose"=true})
     */
    public function homepageAction(Request $request, EntityManagerInterface $em, UserInterface $user = null)
    {
        $request->query->get('search') ? $search = $request->query->get('search') : $search = null;
        $request->query->get('search-choice') ? $choice = $request->query->get('search-choice') : $choice = null;
        $urlGoogleBooks = null;
        $response = null;
        $collectionBooks = null;
        $wishBooks = null;
        $categs = null;
        $message = null;
        $byAuthor = null;

        if ($search === null && $request->query->get('search-button')) {
            $this->addFlash('danger', 'Le champ de recherche ne doit pas être vide');
        }
        elseif ($choice === 'global') {
            (is_numeric($search) && (strlen($search) === 10 || strlen($search) === 13)) ? $type = 'isbn' : $type = 'intitle';
            if ($request->query->get('author') === 'author') {
                $type = 'inauthor';
                $byAuthor = true;
            }
            ($search && $type) ? $urlGoogleBooks = 'https://www.googleapis.com/books/v1/volumes?q='.$type.':'.str_replace(' ', '+', $search).'&maxResults=40' : $urlGoogleBooks = null;
            $restClient = $this->container->get('circle.restclient');
            $response = $restClient->get($urlGoogleBooks);
            $response = json_decode($response->getContent());
            $collectionBooks = $user->getCollections();
            $wishBooks = $user->getBookwishes();
            $categs = $em->getRepository(Category::class)->findAll();
            if ($response->totalItems === 0) {
              $message = 'Désolé, nous n\'avons rien trouvé concernant cette recherche via Google Books... Une fonctionnalité future vous permettra d\'ajouter un livre via un formulaire suite à approbation d\'un administrateur. En attendant, vous pouvez toujours nous contacter pour qu\'on le crée pour vous !';
            }
        }
        elseif ($choice === 'collection') {
            $collectionBooks = $em->getRepository(Book::class)->getUserBooksCollectionByTitleOrIsbn($search, $user->getId());
            if ($request->query->get('author') === 'author') {
                $collectionBooks = $em->getRepository(Book::class)->getUserBooksCollectionByAuthor($search, $user->getId());
                $byAuthor = true;
            }
            if (empty($collectionBooks)) {
              $message = 'Désolé, nous n\'avons rien trouvé concernant cette recherche dans votre collection...';
            }
        }
        elseif ($choice === 'wishlist') {
            $wishBooks = $em->getRepository(Book::class)->getUserWishBooksByTitleOrIsbn($search, $user->getId());
            if ($request->query->get('author') === 'author') {
                $wishBooks = $em->getRepository(Book::class)->getUserWishBooksByAuthor($search, $user->getId());
                $byAuthor = true;
            }
            if (empty($wishBooks)) {
              $message = 'Désolé, nous n\'avons rien trouvé concernant cette recherche dans votre liste de souhaits...';
            }
        }

        return $this->render('home/index.html.twig', array(
            'search' => $search,
            'choice' => $choice,
            'collectionBooks' => $collectionBooks,
            'wishBooks' => $wishBooks,
            'response' => $response,
            'urlGoogleBooks' => $urlGoogleBooks,
            'categs' => $categs,
            'message' => $message,
            'byAuthor' => $byAuthor,
        ));
    }

    /**
     * @Route("/add/book", name="add_book")
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     */
    public function addBookAction(Request $request, EntityManagerInterface $em, UserInterface $user = null)
    {
        if($user === null) {
            throw new NotFoundHttpException('Cet utilisateur n\'existe pas...');
        }
        $book = $request->query->get('book');
        $bookInDb = $em->getRepository(Book::class)->findOneByTitle($book['title']);
        if (!$bookInDb) {
            $newBook = new Book;
            $newBook->setTitle($book['title']);
            isset($book['description']) ? $newBook->setDescription($book['description']) : false;
            isset($book['pageCount']) ? $newBook->setPageCount($book['pageCount']) : false;
            if (isset($book['publishedDate'])) {
                if(strlen($book['publishedDate']) === 4) {
                    $newBook->setPublishedAt(new \DateTime('' . $book['publishedDate'] . '-01-01'));
                }
                elseif(strlen($book['publishedDate']) === 7) {
                    $newBook->setPublishedAt(new \DateTime('' . $book['publishedDate'] . '-01'));
                }
                else {
                    $newBook->setPublishedAt(new \DateTime($book['publishedDate']));
                }
            };
            isset($book['publisher']) ? $newBook->setEditor($book['publisher']) : false;
            isset($book['imageLinks']['thumbnail']) ? $newBook->setPicture($book['imageLinks']['thumbnail']) : false;
            foreach ($book['industryIdentifiers'] as $isbn) {
                $isbn['type'] === "ISBN_10" ? $newBook->setIsbn10($isbn['identifier']) : $newBook->setIsbn13($isbn['identifier']);
            }
            if (isset($book['authors'])) {
                foreach ($book['authors'] as $author) {
                    $authorInDb = $em->getRepository(Author::class)->findOneByAuthorName($author);
                    if (!$authorInDb) {
                        $newAuthor = new Author;
                        $newAuthor->setAuthorName($author);
                        $em->persist($newAuthor);
                    }
                    $authorInDb ? $newBook->addAuthor($authorInDb) : $newBook->addAuthor($newAuthor);
                }
            }
            $em->persist($newBook);
            $em->flush();
        }

        if ($request->request->get('collection') !== null) {
            $collection = new Collection;
            $bookInDb ? $collection->setBook($bookInDb) : $collection->setBook($newBook);
            $collection->setUser($user);
            if ($request->request->get('categ')) {
                $collection->setCategory($em->getRepository(Category::class)->findOneById($request->request->get('categ')));
            }
            $em->persist($collection);
            $em->flush();

            return $this->redirectToRoute('my_collection', array(
                'id' => $user->getId(),
            ));
        }

        if ($request->request->get('wishlist') !== null) {
            $bookInDb ? $user->addBookwish($bookInDb) : $user->addBookwish($newBook);
            $em->flush();

            return $this->redirectToRoute('my_wishlist', array(
                'id' => $user->getId(),
            ));
        }
    }

    /**
     * @Route("/user/collection", name="user_getcollection", options={"expose"=true})
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     */
    public function userCollectionAction(Request $request, UserInterface $user = null)
    {
        // Give a user for React test
        $user === null ? $user = $this->container->get('doctrine')->getRepository(User::class)->findOneByUsername('Ben') : $user;

        if($request->isXmlHttpRequest() && $user)  {
            $jsonContent = $this->container->get('jms_serializer')->serialize(['books' => $user->getCollections()], 'json', SerializationContext::create()->enableMaxDepthChecks());

            return $this->json(['collection' => $jsonContent]);
        } else {
            throw $this->createNotFoundException('Ce n\'est pas une requête Ajax...');
        }
    }

    /**
     * @Route("/book/create", name="book_create", options={"expose"=true})
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     */
    public function bookCreateAction(Request $request, UserInterface $user, EntityManagerInterface $em)
    {
         if($request->isXmlHttpRequest() && $user)  {
            $book = $this->container->get('jms_serializer')->deserialize($request->request->get('book'), 'AppBundle\Entity\Book', 'json');
            $em->persist($book);
            $em->flush();

            return $this->json(['message' => 'Book created']);
        } else {
            throw $this->createNotFoundException('Ce n\'est pas une requête Ajax...');
        }
    }
}
