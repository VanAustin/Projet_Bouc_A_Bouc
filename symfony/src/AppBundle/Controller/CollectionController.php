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

use AppBundle\Entity\Collection;
use AppBundle\Entity\User;
use AppBundle\Entity\Category;

class CollectionController extends Controller
{
    /**
     * @Route("/mycollection/{id}", name="my_collection")
     * @Security("has_role('ROLE_USER')")
     */
    public function myCollectionAction(UserInterface $user = null, Request $request, EntityManagerInterface $em)
    {
        if($user === null) {
            throw new NotFoundHttpException('La collection de cet utilisateur n\'existe pas...');
        }

        $collection = $user->getCollections();
        $categs = $em->getRepository(Category::class)->findAll();

        return $this->render('collection/my_collection.html.twig', array(
            'collection' => $collection,
            'categs' => $categs,
        ));
    }

     /**
       * Supprimer (de manière totalement pacifiste) un livre de sa collection
       *
       * @Route("my_collection/delete/{id}", name="delete_book")
       * @Security("has_role('ROLE_USER')")
       */
    public function removeBookAction(UserInterface $user = null, EntityManagerInterface $em, Collection $collection = null)
    {
        if($collection === null) {
            throw new NotFoundHttpException('Cette collection n\'existe pas...');
        }

        $em->remove($collection);
        $em->flush();
        $this->addFlash('success', $collection->getBook() .' est enlevé de votre collection');

        return $this->redirectToRoute('my_collection', array('id'=>$user->getId()));
    }

    /**
      * Ouvrir ou non un livre de sa collection aux demandes de prêt de ses amis
      *
      * @Route("my_collection/loanable/{id}", name="loanable_book")
      * @Security("has_role('ROLE_USER')")
      */
    public function loanableBookAction(UserInterface $user = null, EntityManagerInterface $em, Collection $collection = null, Request $request)
    {
        if($collection === null) {
            throw new NotFoundHttpException('Cette collection n\'existe pas...');
        }

        if ($request->request->get('loanable') !== null) {
            $collection->setLoanable(true);
            $em->flush();

            return $this->redirectToRoute('my_collection', array(
                'id' => $user->getId(),
            ));
        }

        if ($request->request->get('notloanable') !== null) {
            $collection->setLoanable(false);
            $em->flush();

            return $this->redirectToRoute('my_collection', array(
                'id' => $user->getId(),
            ));
        }
    }

    /**
      * Faire une demande de prêt sur un livre de la collection d'un de ses amis
      *
      * @Route("request/loanable/{id}", name="loan_request")
      * @Security("has_role('ROLE_USER')")
      */
    public function loanableRequestAction(UserInterface $user = null, EntityManagerInterface $em, Collection $collection = null, Request $request)
    {
        if($collection === null) {
            throw new NotFoundHttpException('Cette collection n\'existe pas...');
        }

        if ($request->request->get('loanrequest') !== null) {
            $collection->setBorrowAsk(true);
            $collection->setBorrower($user->getUsername());
            $em->flush();

            return $this->redirectToRoute('friend_show', array(
                'id' => $collection->getUser()->getId(),
            ));
        }
    }

    /**
      * Gérer ses prêts etc.
      *
      * @Route("loan/management", name="loan_management")
      * @Security("has_role('ROLE_USER')")
      */
    public function loanManagementAction(UserInterface $user = null, EntityManagerInterface $em)
    {
        if($user === null) {
            throw new NotFoundHttpException('Cet utilisateur n\'existe pas...');
        }

        $myLoans = $em->getRepository(Collection::class)->findByBorrower($user->getUsername());
        $userRepo = $em->getRepository(User::class);

        return $this->render('collection/loan_management.html.twig', array(
            'user' => $user,
            'myLoans' => $myLoans,
            'userRepo' => $userRepo,
        ));
    }

    /**
      * Accepter ou refuser une demande de prêt de livre de la part d'un utilisateur
      *
      * @Route("handle/loanable/{id}", name="loan_handle")
      * @Security("has_role('ROLE_USER')")
      */
    public function loanHandleAction(Request $request, EntityManagerInterface $em, Collection $collection = null)
    {
        if($collection === null) {
            throw new NotFoundHttpException('Cette collection n\'existe pas...');
        }

        if ($request->request->get('accept') !== null) {
            $collection->setBorrowed(true);
            $collection->setBorrowDate(new \DateTime);
            $em->flush();
        }

        if ($request->request->get('refuse') !== null) {
            $collection->setBorrowAsk(false);
            $collection->setBorrower(null);
            $em->flush();
        }

        if ($request->request->get('end') !== null) {
            $collection->setBorrowed(false);
            $collection->setBorrowDate(null);
            $collection->setBorrowAsk(false);
            $collection->setBorrower(null);
            $em->flush();
        }

        return $this->redirectToRoute('loan_management');
    }

    /**
     * @Route("loan/notifs", name="loan_notifs", options={"expose"=true})
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     */
    public function loanNotifsAction(Request $request, UserInterface $user, EntityManagerInterface $em)
    {
        if($request->isXmlHttpRequest() && $user)  {
            $loanRequests = $em->getRepository(Collection::class)->getLoanRequests($user->getId());
            $loanRequestsNumber = count($loanRequests);

            return $this->json(['loanRequests' => $loanRequestsNumber]);
        } else {
            throw $this->createNotFoundException('Ce n\'est pas une requête Ajax...');
        }
    }

    /**
      * Changer la catégorie d'un livre de sa collection
      *
      * @Route("change/categ/{id}", name="change_categ")
      * @Security("has_role('ROLE_USER')")
      */
    public function changeCategAction(Request $request, UserInterface $user = null, EntityManagerInterface $em, Collection $collection = null)
    {
        if($collection === null) {
            throw new NotFoundHttpException('Cette collection n\'existe pas...');
        }

        if ($request->request->get('change-categ') !== null) {
            $collection->setCategory($em->getRepository(Category::class)->findOneById($request->request->get('categ')));
            $em->flush();
        }

        return $this->redirectToRoute('my_collection', array(
            'id' => $user->getId(),
        ));
    }
}
