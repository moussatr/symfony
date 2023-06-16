<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Carcategory;
use App\Form\CarType;
use App\Form\SearchType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    

    public function search(Request $request, EntityManagerInterface $em, CarRepository $carRepository, PaginatorInterface $paginator)
    {
         $categories = $em->getRepository(Carcategory::class)->findAll();
            
        $query = $carRepository->createQueryBuilder('p')
        ->getQuery();
          // Paginer les résultats
          $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Numéro de page actuel
            10 // Nombre d'éléments par page
        );

        // Créez le formulaire en passant les catégories en option
        $form = $this->createForm(SearchType::class, null, [
            'categories' => $categories,
        ]);
    
        $form->handleRequest($request);
    
        $results = [];
    
        if ($form->isSubmitted() && $form->isValid()) {
            $searchTerm = $form->getData()['searchTerm'];
            $category = $form->getData()['category'];
    
            // Utilisez $searchTerm et $category pour effectuer la recherche dans votre repository
            $results = $carRepository->findBySearchTermAndCategory($searchTerm, $category);
        }
    
        return $this->renderForm('search/index.html.twig', [
            'form' => $form,
            'pagination' => $pagination,
        ]);
    }
    

   



    // public function index(): Response
    // {
    //     return $this->render('search/index.html.twig', [
    //         'controller_name' => 'SearchController',
    //     ]);
    // }
}
