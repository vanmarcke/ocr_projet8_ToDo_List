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
    public function showListActionToDo(bool $isDone = false): array;

    /**
     * Manage the recovery of tasks done.
     *
     * @return array returns the list of done tasks
     */
    public function showListActionIsDone(bool $isDone = true): array;

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

    /**
     * Manage task status modification.
     *
     * @return Task $task
     */
    public function manageToggleAction(Task $task): Task;

    /**
     * Method manageDeleteAction.
     */
    public function manageDeleteAction(Task $task): void;
}
