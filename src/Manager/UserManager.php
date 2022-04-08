<?php

namespace App\Manager;


use App\Repository\UserRepository;


class UserManager implements UserManagerInterface
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function manageListAction(): array
    {
        return $this->userRepository->findAll();
    }
}
