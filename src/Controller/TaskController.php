<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TaskController extends AbstractController
{

    #[Route('/tasks', name: 'task_list')]
    public function listAction(): Response
    {
        return $this->render(
            'task/list.html.twig',
            ['tasks' => $this->getDoctrine()->getRepository(Task::class)->findAll()]
        );
    }

    #[Route('/tasks/create', name: 'task_create')]
    public function createAction(
        Request $request,
    ): Response {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->getUser()) {
            $entityManager = $this->getDoctrine()->getManager();
            $task->setAuthor($this->getUser());
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }
        if (!$this->getUser()) {
            $this->addFlash('authenticated', 'Vous devez vous connecter pour créer une tâche');
        }
        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/tasks/{id}/edit', name: 'task_edit')]
    public function editAction(Task $task = null, Request $request): Response
    {
        if (empty($task)) {
            return $this->notExistTask();
        }

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route('/tasks/{id}/toggle', name: 'task_toggle')]
    public function toggleTaskAction(Task $task = null): RedirectResponse | Response
    {
        if (empty($task)) {
            return $this->notExistTask();
        }

        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash(
            'success',
            sprintf(
                'La tâche %s a bien été marquée comme faite.',
                $task->getTitle()
            )
        );

        return $this->redirectToRoute('task_list');
    }

    #[Route('/tasks/{id}/delete', name: 'task_delete')]
    public function deleteTaskAction(Task $task = null): RedirectResponse | Response
    {
        if (empty($task)) {
            return $this->notExistTask();
        }

        try {
            $this->denyAccessUnlessGranted('delete_task', $task);
        } catch (AccessDeniedException $exception) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer cette tâche');

            return $this->redirectToRoute('task_list');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($task);
        $entityManager->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }

    public function notExistTask(): Response
    {
        $this->addFlash('error', "Cette tâche n'existe pas");

        return $this->render(
            'task/list.html.twig',
            ['tasks' => $this->getDoctrine()->getRepository(Task::class)->findAll()]
        );
    }
}
