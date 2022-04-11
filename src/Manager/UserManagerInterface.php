<?php

namespace App\Manager;

use App\Entity\User;

interface UserManagerInterface
{
    /**
     * Handle users list recovery from database.
     *
     * @return array Contains list of users
     */
    public function manageListAction(): array;

    /**
     * Handle user creation or edition in database.
     *
     * @param User        $user     contains user information
     * @param string|null $password contains PasswordHasher
     */
    public function manageCreateUser(User $user, ?string $password = null): void;

    /**
     * Handle user creation or edition in database.
     *
     * @param User        $user     contains user information
     * @param bool        $persist  save the User if true
     * @param string|null $password contains PasswordHasher
     */
    public function manageUpdateUser(User $user, ?string $password = null): void;
}
