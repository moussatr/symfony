<?php

namespace App\Controller;

use App\Entity\Carcategory;
use App\Form\CarcategoryType;
use App\Repository\CarcategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/carcategory')]
class AdminCarcategoryController extends AbstractController
{
    #[Route('/', name: 'app_admin_carcategory_index', methods: ['GET'])]
    public function index(Request $request, CarcategoryRepository $carcategoryRepository, PaginatorInterface $paginator): Response
    {
        $query = $carcategoryRepository->createQueryBuilder('p')
        ->getQuery();
          // Paginer les résultats
          $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Numéro de page actuel
            20 // Nombre d'éléments par page
        );
        return $this->render('admin_carcategory/index.html.twig', [
            // 'carcategories' => $carcategoryRepository->findAll(),
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_admin_carcategory_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarcategoryRepository $carcategoryRepository): Response
    {
        $carcategory = new Carcategory();
        $form = $this->createForm(CarcategoryType::class, $carcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carcategoryRepository->save($carcategory, true);

            return $this->redirectToRoute('app_admin_carcategory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_carcategory/new.html.twig', [
            'carcategory' => $carcategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_carcategory_show', methods: ['GET'])]
    public function show(Carcategory $carcategory): Response
    {
        return $this->render('admin_carcategory/show.html.twig', [
            'carcategory' => $carcategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_carcategory_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Carcategory $carcategory, CarcategoryRepository $carcategoryRepository): Response
    {
        $form = $this->createForm(CarcategoryType::class, $carcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carcategoryRepository->save($carcategory, true);

            return $this->redirectToRoute('app_admin_carcategory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_carcategory/edit.html.twig', [
            'carcategory' => $carcategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_carcategory_delete', methods: ['POST'])]
    public function delete(Request $request, Carcategory $carcategory, CarcategoryRepository $carcategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carcategory->getId(), $request->request->get('_token'))) {
            $carcategoryRepository->remove($carcategory, true);
        }

        return $this->redirectToRoute('app_admin_carcategory_index', [], Response::HTTP_SEE_OTHER);
    }
}
