<?php

namespace App\Manager;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Component\Security\Core\Security;

class TaskManager implements TaskManagerInterface
{
    public function __construct(private TaskRepository $taskRepository, private Security $security)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function showListActionToDo(bool $isDone = false): array
    {
        return $this->taskRepository->findBy(['isDone' => $isDone]);
    }

    /**
     * {@inheritdoc}
     */
    public function showListActionIsDone(bool $isDone = true): array
    {
        return $this->taskRepository->findBy(['isDone' => $isDone]);
    }

    /**
     * {@inheritdoc}
     */
    public function manageCreateTask(Task $task = null): void
    {
        if (null !== $task) {
            $task->setAuthor($this->security->getUser());
        }
        $this->taskRepository->save($task);
    }

    /**
     * {@inheritdoc}
     */
    public function manageEditTask(Task $task = null): void
    {
        if (null !== $task) {
            $task->setAuthor($this->security->getUser());
        }
        $this->taskRepository->update($task);
    }

    /**
     * {@inheritdoc}
     */
    public function manageToggleAction(Task $task): Task
    {
        $task->toggle(!$task->isDone());
        $this->taskRepository->update($task);

        return $task;
    }

    /**
     * {@inheritdoc}
     */
    public function manageDeleteAction(Task $task): void
    {
        $this->taskRepository->delete($task);
    }
}
