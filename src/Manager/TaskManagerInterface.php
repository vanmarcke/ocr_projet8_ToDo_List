<?php

namespace App\Manager;

interface TaskManagerInterface
{
    /**
     * Manage collection of to-do items.
     *
     * @return array returns the to-do list
     */
    public function showListActionToDo(): array;

    /**
     * Manage the recovery of tasks done.
     *
     * @return array returns the list of done tasks
     */
    public function showListActionIsDone(): array;
}
