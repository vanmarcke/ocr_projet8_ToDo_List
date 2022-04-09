<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Manager\TaskManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/tasks/create', name: 'task_create')]
    public function createAction(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskManager->manageCreateTask($task);
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_todo_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }
}