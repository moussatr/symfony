<?php

namespace App\Controller;

use App\Entity\Carcategory;
use App\Form\Carcategory1Type;
use App\Repository\CarcategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/carcategory')]
class CarcategoryController extends AbstractController
{
    #[Route('/', name: 'app_carcategory_index', methods: ['GET'])]
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
        return $this->render('carcategory/index.html.twig', [
            // 'carcategories' => $carcategoryRepository->findAll(),
            'pagination' => $pagination,
        ]);
    }

 

    #[Route('/{id}', name: 'app_carcategory_show', methods: ['GET'])]
    public function show(Carcategory $carcategory): Response
    {
        return $this->render('carcategory/show.html.twig', [
            'carcategory' => $carcategory,
        ]);
    }

 

   
}
