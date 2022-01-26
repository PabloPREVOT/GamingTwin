<?php

namespace App\Controller;

use App\Repository\JoueurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(JoueurRepository $jr, EntityManagerInterface $entityManager): Response
    {
        $userSupprimer = $jr->findBy(
            ['supprimer' => true],
        );

        if(count($userSupprimer) >= 1){
            foreach($userSupprimer as $user){
                $entityManager->remove($user);
                $entityManager->flush();
            }   
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "hidden" => false,
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig', [
            "hidden" => false,
        ]);
    }
}
