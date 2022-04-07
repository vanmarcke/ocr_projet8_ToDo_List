<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager implements UserManagerInterface
{
    public function __construct(private UserRepository $userRepository, private EntityManagerInterface $entityManager, private UserPasswordHasherInterface $encoder)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function manageListAction(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function manageCreateOrUpdate(User $user, bool $persist = true, string $password = null): void
    {
        if (null !== $user->getPassword()) {
            $password = $this->encoder->hashPassword($user, $user->getPassword());
        } 
        $user->setPassword($password);
        if ($persist) {
            $this->entityManager->persist($user);
        }
        $this->entityManager->flush();
    }
}
