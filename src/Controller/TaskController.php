<?php

namespace App\Controller;

use App\Manager\TaskManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    public function __construct(private TaskManagerInterface $taskManager)
    {
    }

    #[Route('/tasks/todo', name: 'task_todo_list')]
    public function listAction(): Response
    {
        return $this->render(
            'task/list.html.twig',
            [
                'tasks' => $this->taskManager->showListActionToDo(),
            ]
        );
    }

    #[Route('/tasks/done', name: 'task_done_list')]
    public function doneListAction(): Response
    {
        return $this->render(
            'task/list.html.twig',
            [
                'tasks' => $this->taskManager->showListActionIsDone(),
                'type' => 'done',
            ]
        );
    }
}
