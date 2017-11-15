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

use AppBundle\Entity\User;
use AppBundle\Entity\Friend;

class FriendController extends Controller
{
    /**
     * @Route("/myfriends/{id}", name="my_friends")
     * @Security("has_role('ROLE_USER')")
     */
    public function myFriendsAction(UserInterface $user = null, Request $request, EntityManagerInterface $em)
    {
        if($user === null) {
            throw new NotFoundHttpException('Cet utilisateur n\'existe pas...');
        }

        $request->query->get('search') !== null && $request->query->get('search') !== '' ? $search = $request->query->get('search') : $search = null;
        $search !== null ? $searchFriends = $em->getRepository(User::class)->getUsersLikeUsername(trim($search)) : $searchFriends = null;

        $request->query->get('search') === '' ? $this->addFlash('danger', 'Le champ de recherche ne doit pas être vide') : false;

        $friends = $user->getFriendsWithMe();
        $friendRequests = $em->getRepository(User::class)->getFriendRequests($user->getId());

        return $this->render('friends/my_friends.html.twig', array(
            'friends' => $friends,
            'friendRequests' => $friendRequests,
            'search' => $search,
            'searchFriends' => $searchFriends,
        ));
    }

    /**
     * @Route("/friend/request/{id}", name="friend_request")
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     */
    public function friendRequestAction(UserInterface $user = null, EntityManagerInterface $em, $id)
    {
        if($user === null) {
            throw new NotFoundHttpException('Cet utilisateur n\'existe pas...');
        }

        $friend = $em->getRepository(User::class)->find($id);
        $friendRequest = new Friend;
        $friendRequest->setUser($user);
        $friendRequest->setHasfriend($friend);
        $em->persist($friendRequest);
        $em->flush();

        return $this->redirectToRoute('my_friends', array(
            'id' => $user->getId(),
        ));
    }

    /**
     * @Route("/friend/accept/{id}", name="friend_accept")
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     */
    public function friendAcceptAction(UserInterface $user = null, EntityManagerInterface $em, $id)
    {
        if($user === null) {
            throw new NotFoundHttpException('Cet utilisateur n\'existe pas...');
        }

        $reverseFriend = $em->getRepository(User::class)->getReverseFriendShip($id, $user->getId());
        $reverseFriend->setAccepted(true);
        $friend = $em->getRepository(User::class)->find($id);
        $friendRequest = new Friend;
        $friendRequest->setUser($user);
        $friendRequest->setHasfriend($friend);
        $friendRequest->setAccepted(true);
        $em->persist($friendRequest);
        $em->flush();

        return $this->redirectToRoute('my_friends', array(
            'id' => $user->getId(),
        ));
    }

    /**
     * @Route("friend/notifs", name="friend_notifs", options={"expose"=true})
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     */
    public function friendNotifsAction(Request $request, UserInterface $user, EntityManagerInterface $em)
    {
        if($request->isXmlHttpRequest() && $user)  {
            $friends = $user->getFriendsWithMe();
            $notifs = 0;
            foreach ($friends as $friend) {
                if(!$friend->getAccepted()) {
                    $notifs += 1;
                }
            };

        return $this->json(['friendNotifs' => $notifs]);
        } else {
            throw $this->createNotFoundException('Ce n\'est pas une requête Ajax...');
        }
    }

    /**
     * Supprimer (de manière totalement pacifiste) un utilisateur de son cercle
     *
     * @Route("/myfriend/delete/{id}", name="delete_friend")
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteFriendAction(UserInterface $user = null, EntityManagerInterface $em, $id)
    {
        $usernameToDel = $em->getRepository(User::class)->findOneById($id)->getUsername();
        if($user === null || $usernameToDel === null) {
            throw new NotFoundHttpException('Cet utilisateur n\'existe pas...');
        }
        
        $friendship = $em->getRepository(User::class)->getReverseFriendShip($id, $user->getId());
        $reversefriendship = $em->getRepository(User::class)->getReverseFriendShip($user->getId(), $id);
        $em->remove($friendship);
        $em->remove($reversefriendship);
        $em->flush();
        $this->addFlash('success', '\'' . $usernameToDel . '\' enlevé de votre cercle');

        return $this->redirectToRoute('my_friends', array(
            'id' => $user->getId(),
        ));
    }

    /**
     * Vue d'un ami, de sa collection, de ses souhaits etc.
     *
     * @Route("/myfriend/{id}", name="friend_show")
     * @Security("has_role('ROLE_USER')")
     */
    public function myFriendAction(UserInterface $user = null, EntityManagerInterface $em, $id)
    {
        $friendShip = $em->getRepository(User::class)->getReverseFriendShip($id, $user->getId());
        $friendShip2 = $em->getRepository(User::class)->getReverseFriendShip($user->getId(), $id);

        if(!$friendShip && !$friendShip2) {
            throw new NotFoundHttpException('Vous n\'êtes pas ami avec cet utilisateur');
        }

        $friend = $em->getRepository(User::class)->findOneById($id);

        return $this->render('friends/friend_show.html.twig', array(
            'friend' => $friend,
        ));
    }
}
