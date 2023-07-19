<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Priority;
use App\Entity\Status;
use App\Form\TaskFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller für das Listen, Bearbeiten, Anlegen und Löschen von Aufgaben (Task).
 */
class ToDoController extends AbstractController
{
    public const LIST_ALL_CODE = 'Alle';
    public const SUCCESS_TASK_CREATED_TXT = 'Aufgabe wurde angelegt.';
    public const SUCCESS_TASK_SAVED_TXT = 'Aufgabe wurde gespeichert.';
    public const ERROR_TASK_HAS_CHILD_TXT = 'Diese Aufgabe hat abhängige Unteraufgaben und kann daher nicht gelöscht werden. Bitte erst die Unteraufgaben löschen.';
    public const SUCCESS_TASK_DELETED_TXT = 'Aufgabe wurde gelöscht.';

    /**
     * @return Response
     */
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_list');
    }

    /**
     * @param EntityManagerInterface $em
     * @param string|null $slug
     * @return Response
     */
    #[Route('/list/{slug}', name: 'app_list')]
    public function listTasks(EntityManagerInterface $em, string $slug = null): Response
    {
        $filter = self::LIST_ALL_CODE;

        if ($slug) {
            $filteredPriority = $em->getRepository(Priority::class)->findOneBy(['code' => $slug]);
            if ($filteredPriority) {
                $filter = $slug;
            }
        }

        if ($filter == self::LIST_ALL_CODE) {
            $tasks = $em->getRepository(Task::class)->findAll();
        } else {
            $tasks = $em->getRepository(Task::class)->findBy(['priority' => $filteredPriority] );
            $filter = $slug;
        }

        $priorities = $em->getRepository(Priority::class)->findAll();
        $status = $em->getRepository(Status::class)->findAll();

        return $this->render('todo/task-list.html.twig', [
            'tasks' => $tasks,
            'priorities' => $priorities,
            'status' => $status,
            'filter' => $filter
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    #[Route('/create/task', name: 'app_create_task')]
    public function createTask(EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(TaskFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            /** @var Task $task */
            $task = $form->getData();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', self::SUCCESS_TASK_CREATED_TXT);

            return $this->redirectToRoute('app_list');
        }

        return $this->render('todo/task-create.html.twig', [
            'taskForm' => $form->createView()
        ]);
    }

    /**
     * @param Task $task
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    #[Route('/edit/task/{id}', name: 'app_edit_task')]
    public function editTask(Task $task, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(TaskFormType::class, $task);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            /** @var Task $task */
            $task = $form->getData();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', self::SUCCESS_TASK_SAVED_TXT);

            return $this->redirectToRoute('app_list');
        }

        return $this->render('todo/task-edit.html.twig', [
            'taskForm' => $form->createView()
        ]);
    }

    /**
     * @param Task $task
     * @param EntityManagerInterface $em
     * @return Response
     */
    #[Route('/delete/task/{id}', name: 'app_delete_task')]
    public function deleteTask(Task $task, EntityManagerInterface $em): Response
    {
        $childTaskCount = $em->getRepository(Task::class)->count(['parent' => $task->getId()]);

        if($childTaskCount > 0){

            $this->addFlash('danger', self::ERROR_TASK_HAS_CHILD_TXT);

        } else {

            $task->setParent( NULL );
            $em->remove($task);
            $em->flush();

            $this->addFlash('success', self::SUCCESS_TASK_DELETED_TXT);

        }
        return $this->redirectToRoute('app_list');

    }

}