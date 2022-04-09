<?php

namespace App\Manager;

use App\Entity\Task;

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

    /**
     * Manage task creation.
     *
     * @param Task $task
     */
    public function manageCreateTask(Task $task = null): void;

    /**
     * Manage task edit.
     *
     * @param Task $task
     */
    public function manageEditTask(Task $task = null): void;
}
