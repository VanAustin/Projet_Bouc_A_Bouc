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

use AppBundle\Entity\Book;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Note;


class BookController extends Controller
{
    /**
     * Page Vue d'un livre de ma collection
     * &&
     * Form for posting Comments
     *
     * @Route("/book_view/{id}", name="book_view")
     * @Security("has_role('ROLE_USER')")
     */
    public function bookViewAction(Book $book = null, Request $request, EntityManagerInterface $em, UserInterface $user)
    {
        if($book === null) {
            throw new NotFoundHttpException('Ce livre n\'existe pas...');
        }

        $comment= new Comment;
        $form = $this->createForm('AppBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $comment->setBook($book);
            $comment->setUser($user);
            $comment->setPublishedAt(new \DateTime);
            $comment->setValid(true);
            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Commentaire créé avec succès');

            return $this->redirectToRoute('book_view', array('id' => $comment->getBook()->getId()));
        }

        return $this->render('book/book_view.html.twig', array(
            'book' => $book,
            'comment'=> $comment,
            'form'=>$form->createView(),
        ));
    }

    /**
     * Attribuer une note à livre depuis la vue d'un livre
     *
     * @Route("/book/note/{id}", name="book_note")
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     */
    public function bookNoteAction(Book $book = null, Request $request, EntityManagerInterface $em, UserInterface $user)
    {
        if($book === null) {
            throw new NotFoundHttpException('Ce livre n\'existe pas...');
        }

        if ($request->request->get('add-note') !== null) {
            if ($request->request->get('given-note') !== null) {
                $givenNote = $request->request->get('given-note');
                if ($givenNote >= 0 and $givenNote <= 5) {
                    $note = new Note;
                    $note->setUser($user);
                    $note->setBook($book);
                    $note->setNote($request->request->get('given-note'));
                    $em->persist($note);
                    $em->flush();

                    $this->addFlash('success', 'Note attribuée avec succès');

                    return $this->redirectToRoute('book_view', array(
                        'id' => $book->getId(),
                    ));
                }
            }
        }

        $this->addFlash('danger', 'Une erreur est survenue');

        return $this->redirectToRoute('book_view', array(
            'id' => $book->getId(),
        ));
    }
}
