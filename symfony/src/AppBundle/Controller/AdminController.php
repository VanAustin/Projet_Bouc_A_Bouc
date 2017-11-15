<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Entity\User;
use AppBundle\Entity\Category;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminAction()
    {
        return $this->render('admin/admin.html.twig');
    }

    /**
     * @Route("/admin/users", name="admin_users")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminUsersAction(EntityManagerInterface $em)
    {
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('admin/admin_users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/user/role/{id}", name="admin_user_role")
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminUserRoleAction(User $user = null, EntityManagerInterface $em, Request $request)
    {
        if($user === null) {
            throw new NotFoundHttpException('Cet utilisateur n\'existe pas...');
        }

        if($request->request->get('remove') !== null) {
            $user->removeRole('ROLE_ADMIN');
            $em->flush();
            $this->addFlash('success', 'Rôle de '. $user->getUsername() .' changé pour Utilisateur avec succès');
        }
        elseif($request->request->get('add') !== null) {
            $user->addRole('ROLE_ADMIN');
            $em->flush();
            $this->addFlash('success', 'Rôle de '. $user->getUsername() .' changé pour Admin avec succès');
        }
        else {
            $this->addFlash('danger', 'Une erreur est survenue...');
        }

        return $this->redirectToRoute('admin_users');
    }

    /**
    * Bloquer un utilisateur
    *
    * @Route("/admin/user/locked/{id}", name="admin_user_locked")
    * @Method("POST")
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function adminLockedUserAction(User $user = null, EntityManagerInterface $em, Request $request)
    {
        if($user === null)
        {
            throw new NotFoundHttpException('Cet utilisateur n\'existe pas...');
        }

        if($request->request->get('locked') !== null)
        {
            $user->setEnabled(0);
            $em->flush();
            $this->addFlash('success', $user->getUsername().' bloqué avec succès');
        }
        elseif($request->request->get('unlocked') !== null) {
            $user->setEnabled(1);
            $em->flush();
            $this->addFlash('success', $user->getUsername() .' débloqué avec succès');
        }
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue...');
        }

        return $this->redirectToRoute('admin_users');
    }

    /**
     * Supprimer (de manière totalement pacifiste) un utilisateur
     *
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminDeleteUserAction(User $user = null)
    {
        if($user === null)
        {
            throw new NotFoundHttpException('Cet utilisateur n\'existe pas...');
        }

        $userManager = $this->container->get('fos_user.user_manager');
        $userManager->deleteUser($user);
        $this->addFlash('succes', $user->getUsername() .' supprimé');

        return $this->redirectToRoute('admin_users');
    }

    /**
     * @Route("/admin/categories", name="admin_categories")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminTagsAction(EntityManagerInterface $em)
    {
        $categories = $em->getRepository(Category::class)->findAll();

        return $this->render('admin/admin_categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("admin/categ/new", name="admin_categ_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminCategNewAction(Request $request, EntityManagerInterface $em)
    {
        $category = new Category;
        $form = $this->createForm('AppBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Catégorie ' . $category->getCategoryName() . ' créée avec succès');

            return $this->redirectToRoute('admin_categories');
        }
        if($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Une erreur est survenue');
        }

        return $this->render('admin/admin_categ_new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/categ/edit/{id}", name="admin_categ_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminCategEditAction(Category $category = null, Request $request, EntityManagerInterface $em)
    {
        if($category === null) {
            throw new NotFoundHttpException('Cette catgéorie n\'existe pas...');
        }

        $deleteForm = $this->createDeleteForm($category);
        $form = $this->createForm('AppBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Catégorie ' . $category->getCategoryName() . ' éditée avec succès');

            return $this->redirectToRoute('admin_categories');
        }
        if($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Une erreur est survenue');
        }

        return $this->render('admin/admin_categ_edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'deleteForm' => $deleteForm->createView(),
        ]);
    }

    /**
     * @Route("admin/categ/delete/{id}", name="admin_categ_delete")
     * @Method({"DELETE"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminTagDeleteAction(Category $category = null, Request $request, EntityManagerInterface $em)
    {
        if($category === null) {
            throw new NotFoundHttpException('Cette catégorie n\'existe pas...');
        }

        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($category);
            $em->flush();
            $this->addFlash('success', 'Catégorie ' . $category->getCategoryName() . ' supprimée avec succès');
        }
        if($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Une erreur est survenue');
        }

        return $this->redirectToRoute('admin_categories');
    }

    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_categ_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
