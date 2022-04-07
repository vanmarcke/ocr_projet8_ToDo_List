<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Manager\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private UserManagerInterface $userManager)
    {
    }

    #[Route('/users', name: 'user_list')]
    public function listAction(): Response
    {
        return $this->render('user/list.html.twig', [
            'controller_name' => 'UserController',
            'users' => $this->userManager->manageListAction(),
        ]);
    }

    #[Route('/users/create', name: 'user_create')]
    public function createAction(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->manageCreateOrUpdate($user);
            $this->addFlash('success', "L'utilisateur a été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/users/{id}/edit', name: 'user_edit')]
    public function editAction(User $user, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user, [
            'require_password' => false, 
        ]);
        $password = $user->getPassword();
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->manageCreateOrUpdate($user, false, $password);
            $this->addFlash('success', "L'utilisateur a été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(), 'user' => $user,
        ]);
    }
}
