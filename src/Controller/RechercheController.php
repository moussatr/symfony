<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CarRepository;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(Request $request, CarRepository $carRepository, PaginatorInterface $paginator): Response
    {

        $query = $carRepository->createQueryBuilder('p')
        ->getQuery();
          // Paginer les résultats
          $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Numéro de page actuel
            20 // Nombre d'éléments par page
        );

        $search = $request->query->get('search');
        $cars = $carRepository->findBySearch($search);
        return $this->render('recherche/index.html.twig', [
            // 'controller_name' => 'RechercheController',
            'cars' => $cars,
            'pagination' => $pagination

        ]);
    }
}
