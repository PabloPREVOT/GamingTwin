<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as Hasher;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    #[Route('profil/{id}/edit', name: 'profil_joueur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Joueur $joueur, EntityManagerInterface $entityManager, Hasher $hasher): Response
    {
        $form = $this->createForm(ProfilType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($mdp = $form->get("password")->getData()) {
                $nouveauMdp = $hasher->hashPassword($joueur, $mdp);
                $joueur->setPassword($nouveauMdp);
            }

            $entityManager->flush();

            return $this->redirectToRoute('profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil/edit.html.twig', [
            'joueur' => $joueur,
            'form' => $form,
        ]);
    }
}
