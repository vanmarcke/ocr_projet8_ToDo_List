<?php

namespace App\Manager;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class TaskManager implements TaskManagerInterface
{
    public function __construct(private TaskRepository $taskRepository, private EntityManagerInterface $entityManager, private Security $security)
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
            $this->entityManager->persist($task);
        }
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function manageEditTask(Task $task = null): void
    {
        if (null !== $task) {
            $task->setAuthor($this->security->getUser());
            $this->entityManager->persist($task);
        }
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function manageToggleAction(Task $task): Task
    {
        $task->toggle(!$task->isDone());
        $this->entityManager->flush();

        return $task;
    }
}
