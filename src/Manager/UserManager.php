<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager implements UserManagerInterface
{
    public function __construct(private UserRepository $userRepository, private UserPasswordHasherInterface $encoder)
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
    public function manageCreateUser(User $user, ?string $password = null): void
    {
        $password = $this->encoder->hashPassword($user, $user->getPassword());

        $user->setPassword($password);

        $this->userRepository->save($user);
    }

    /**
     * {@inheritdoc}
     */
    public function manageUpdateUser(User $user, bool $persist = true, ?string $password = null): void
    {
        if (null !== $user->getPassword()) {
            $password = $this->encoder->hashPassword($user, $user->getPassword());
        }
        $user->setPassword($password);

        $this->userRepository->update($user);
    }
}
