<?php

namespace App\Manager;

interface UserManagerInterface
{
    /**
     * Handle users list recovery from database.
     *
     * @return array Contains list of users
     */
    public function manageListAction(): array;
}
