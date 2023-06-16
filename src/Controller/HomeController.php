<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // $url = "https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&hourly=temperature_2m";
    
        // $raw = file_get_contents($url);
    
        // $json = json_decode($raw);
    
        // $var = var_dump($json);

        // $name = $json->name;

        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            // 'var' => $var,
        ]);
    }
    
  
     

}
