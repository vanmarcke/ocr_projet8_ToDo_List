<?php

namespace App\Manager;

use App\Repository\TaskRepository;

class TaskManager implements TaskManagerInterface
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function showListActionToDo(): array
    {
        return $this->taskRepository->findBy(['IsDone' => '0']);
    }

    /**
     * {@inheritdoc}
     */
    public function showListActionIsDone(): array
    {
        return $this->taskRepository->findBy(['IsDone' => '1']);
    }
}
