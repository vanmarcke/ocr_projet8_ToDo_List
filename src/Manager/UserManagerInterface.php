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
     * @param User   $user
     * @param bool   $persist
     * @param string $password
     *
     * @return void
     */
    public function manageCreateOrUpdate(User $user, bool $persist = true, string $password = null): void;
}
