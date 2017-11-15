<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Entity\Book;
use AppBundle\Entity\Collection;

class WishlistController extends Controller
{
    /**
    * @Route("wishlist/my_wishlist/{id}", name="my_wishlist")
    * @Security("has_role('ROLE_USER')")
    */
    public function myWishlistAction(UserInterface $user = null, Request $request)
    {
        if ($user === null) {
            throw new NotFoundHttpException('La liste de souhaits de cet utilisateur n\'existe pas...');
        }
        $bookwishes = $user->getBookwishes();

        return $this->render('wishlist/my_wishlist.html.twig', [
            'bookwishes' => $bookwishes,
        ]);
    }

    /**
    * Supprimer (de manière totalement pacifiste) un livre de sa liste de souhaits
    *
    * @Route("my_wishlist/delete/{id}", name="delete_bookwishes")
    * @Security("has_role('ROLE_USER')")
    */
    public function removeBookAction(UserInterface $user = null, EntityManagerInterface $em, Book $book)
    {
        if($user === null) {
            throw new NotFoundHttpException('La liste de souhaits de cet utilisateur n\'existe pas...');
        }
        if($book === null) {
            throw new NotFoundHttpException('Vous n\'avez pas ce livre dans votre liste de souhaits...');
        }

        $user->removeBookwish($book);
        $em->flush();
        $this->addFlash('success', $book->getTitle() .' est enlevé de votre liste de souhaits');

        return $this->redirectToRoute('my_wishlist', array('id'=>$user->getId()));
    }

    /**
    * Transférer un livre de sa wishlist à sa collection
    *
    * @Route("wish/to/collection/{id}", name="wish_to_collection")
    * @Security("has_role('ROLE_USER')")
    */
    public function wishToCollectionAction(UserInterface $user = null, EntityManagerInterface $em, Book $book)
    {
        if($user === null) {
            throw new NotFoundHttpException('La liste de souhaits de cet utilisateur n\'existe pas...');
        }
        if($book === null) {
            throw new NotFoundHttpException('Vous n\'avez pas ce livre dans votre liste de souhaits...');
        }

        $user->removeBookwish($book);
        $collection = new Collection;
        $collection->setBook($book);
        $collection->setUser($user);
        $em->persist($collection);
        $em->flush();

        $this->addFlash('success', $book->getTitle() .' est enlevé de votre liste de souhaits et ajouté à votre collection');

        return $this->redirectToRoute('my_collection', array('id'=>$user->getId()));
    }
}
