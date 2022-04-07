<?php

namespace App\Controller;

use App\Manager\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            'users' => $this->userManager->manageListAction()
        ]);
    }
}
